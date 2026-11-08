<?php

namespace App\Actions\Skills;

use App\Enums\ExerciseSource;
use App\Enums\QuestionType;
use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Exceptions\AiUnavailableException;
use App\Exceptions\NothingToReadException;
use App\Models\CurriculumUnit;
use App\Models\ExerciseQuestion;
use App\Models\SkillExercise;
use App\Models\User;
use App\Services\Ai\OpenRouterClient;
use App\Services\Uploads\TestFileStore;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReadExerciseFromUpload
{
    /** Skills a test can be read into. Writing tasks are short enough to type. */
    public const SKILLS = [SkillType::Language, SkillType::Reading, SkillType::Listening];

    private const MAX_QUESTIONS = 60;

    public function __construct(
        private readonly OpenRouterClient $ai,
        private readonly TestFileStore $files,
    ) {}

    /**
     * Read the photos or PDF of a test the teacher wrote into a draft exercise they own.
     *
     * The AI transcribes; it does not write content. Every question it was unsure of is marked
     * for the teacher to check against the original, which stays beside the editor. Only the
     * files and the kind of exercise are sent — nothing about the teacher or any student.
     *
     * @param  list<UploadedFile>  $uploads
     *
     * @throws AiUnavailableException
     * @throws NothingToReadException
     */
    public function handle(User $teacher, array $uploads, SkillType $skill, ?CurriculumUnit $unit, ?int $grade): SkillExercise
    {
        $paths = array_map(fn (UploadedFile $upload) => $this->files->store($upload), $uploads);

        try {
            $payload = $this->read($paths, $skill, $unit?->grade ?? $grade);
        } catch (AiUnavailableException|NothingToReadException $e) {
            $this->files->delete($paths);

            throw $e;
        }

        return DB::transaction(function () use ($teacher, $skill, $unit, $grade, $paths, $payload) {
            $exercise = SkillExercise::create([
                'curriculum_unit_id' => $unit?->id,
                'owner_id' => $teacher->id,
                'source' => ExerciseSource::Upload,
                'grade' => $unit ? null : $grade,
                'skill' => $skill,
                'title_en' => $payload['title_en'],
                'title_vi' => $payload['title_vi'],
                'instructions_en' => $payload['instructions_en'],
                'instructions_vi' => $payload['instructions_vi'],
                'passage' => $payload['passage'],
                'status' => TopicStatus::Draft,
                'model' => $this->model(),
                'source_files' => [
                    'files' => $paths,
                    'skipped' => $payload['skipped'],
                    'looks_like_textbook' => $payload['looks_like_textbook'],
                ],
            ]);

            foreach ($payload['questions'] as $index => $question) {
                $exercise->questions()->create([...$question, 'sort_order' => $index + 1]);
            }

            return $exercise->load('questions');
        });
    }

    /**
     * @param  list<string>  $paths
     * @return array{title_en: string, title_vi: string, instructions_en: string, instructions_vi: string, passage: ?string, questions: list<array<string, mixed>>, skipped: list<string>, looks_like_textbook: bool}
     */
    private function read(array $paths, SkillType $skill, ?int $grade): array
    {
        $parts = [['type' => 'text', 'text' => "Kind of exercise: {$skill->value}.".($grade ? " Grade {$grade}." : '')]];

        foreach ($paths as $index => $path) {
            $parts[] = str_ends_with($path, '.pdf')
                ? ['type' => 'file', 'file' => ['filename' => 'test-'.($index + 1).'.pdf', 'file_data' => $this->files->dataUrl($path)]]
                : ['type' => 'image_url', 'image_url' => ['url' => $this->files->dataUrl($path)]];
        }

        $answer = $this->ai->chat(
            [['role' => 'system', 'content' => $this->systemPrompt()], ['role' => 'user', 'content' => $parts]],
            model: $this->model(),
            maxTokens: 6000,
            temperature: 0.0,
            timeout: (int) config('services.openrouter.vision_timeout'),
        );

        $json = trim(preg_replace('/^```(?:json)?|```$/m', '', $answer));
        $payload = json_decode($json, true);

        if (! is_array($payload) || ! is_array($payload['questions'] ?? null)) {
            Log::warning('Uploaded test could not be parsed', ['answer' => mb_substr($answer, 0, 500)]);

            throw new AiUnavailableException('The uploaded test could not be read.');
        }

        $skipped = array_values(array_filter(array_map(fn ($part) => is_string($part) ? trim($part) : null, (array) ($payload['skipped'] ?? []))));
        $questions = [];

        foreach (array_slice(array_filter($payload['questions'], 'is_array'), 0, self::MAX_QUESTIONS) as $item) {
            $question = $this->question($item);

            if ($question === null) {
                $skipped[] = mb_substr(trim((string) ($item['prompt'] ?? '')), 0, 200) ?: 'Unsupported question';

                continue;
            }

            $questions[] = $question;
        }

        $passage = filled($payload['passage'] ?? null) ? mb_substr(trim((string) $payload['passage']), 0, 4000) : null;

        if ($questions === []) {
            throw new NothingToReadException;
        }

        return [
            'title_en' => $this->text($payload['title_en'] ?? null, 150) ?? 'Uploaded test',
            'title_vi' => $this->text($payload['title_vi'] ?? null, 150) ?? 'Đề tải lên',
            'instructions_en' => $this->text($payload['instructions_en'] ?? null, 300) ?? 'Answer the questions.',
            'instructions_vi' => $this->text($payload['instructions_vi'] ?? null, 300) ?? 'Làm các câu dưới đây.',
            'passage' => $passage,
            'questions' => $questions,
            'skipped' => array_slice($skipped, 0, 30),
            'looks_like_textbook' => (bool) ($payload['looks_like_textbook'] ?? false),
        ];
    }

    /**
     * One question as stored, or null when its type is not one the app can show. Anything that
     * does not hold together (answer missing, or not among the options) is kept but marked.
     *
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>|null
     */
    private function question(array $item): ?array
    {
        $type = QuestionType::tryFrom((string) ($item['type'] ?? ''));
        $prompt = $this->text($item['prompt'] ?? null, 500);

        if (! $type || ! $prompt) {
            return null;
        }

        $answer = $this->text($item['answer'] ?? null, 200) ?? '';
        $needsCheck = (bool) ($item['needs_check'] ?? false) || $answer === '';

        $options = null;
        if ($type->hasOptions()) {
            $options = $type === QuestionType::TrueFalse
                ? ['True', 'False']
                : array_values(array_unique(array_filter(array_map(
                    fn ($option) => $this->text(is_string($option) ? preg_replace('/^\s*[A-Da-d][.)]\s+/u', '', $option) : null, 200),
                    (array) ($item['options'] ?? []),
                ))));

            $needsCheck = $needsCheck || count($options) < 2 || ! in_array($answer, $options, true);
        }

        // An "underlined part" question whose options lost their [marks] would show no underline.
        if ($type === QuestionType::Pronunciation && str_contains(mb_strtolower($prompt), 'underline')) {
            $needsCheck = $needsCheck || collect($options)->contains(fn (string $option) => ! str_contains($option, '['));
        }

        if ($type === QuestionType::Reorder) {
            $words = fn (string $text) => collect(explode(' ', ExerciseQuestion::normalise(str_replace('/', ' ', $text))))->filter()->sort()->values()->all();
            $needsCheck = $needsCheck || $words($prompt) !== $words($answer);
        }

        $accepted = $type->acceptsAlternatives()
            ? array_values(array_filter(array_map(fn ($a) => $this->text(is_string($a) ? $a : null, 200), (array) ($item['accepted_answers'] ?? []))))
            : [];

        return [
            'type' => $type,
            'prompt' => $prompt,
            'options' => $options,
            'answer' => $answer,
            'accepted_answers' => $accepted ?: null,
            'explanation_vi' => $this->text($item['explanation_vi'] ?? null, 300),
            'needs_check' => $needsCheck,
        ];
    }

    private function text(mixed $value, int $max): ?string
    {
        $value = is_string($value) ? trim($value) : '';

        return $value === '' ? null : mb_substr($value, 0, $max);
    }

    private function model(): string
    {
        return (string) (config('services.openrouter.vision_model') ?: config('services.openrouter.model'));
    }

    private function systemPrompt(): string
    {
        return <<<'PROMPT'
        You turn an English test written by a Vietnamese lower-secondary teacher (grades 6-9) into exercise data.
        You are transcribing, not writing: never invent, reword, add or drop a question. Keep the teacher's order.

        Question types and how to fill them:
        - multiple_choice: prompt = the stem, with any blank written as ___; options = the choices without their letters; answer = the correct option, copied exactly.
        - true_false: prompt = the statement; options = ["True", "False"]; answer = "True" or "False".
        - gap_fill: prompt = the sentence with ___ for the gap; answer = the missing word(s). Use this for "give the correct form of the word/verb".
        - reorder: prompt = the given words separated by " / "; answer = the correct sentence using exactly those words.
        - rewrite: prompt = the original sentence followed by the instruction or cue in round brackets, e.g. "My bag is lighter than your bag. (Your bag is ...)"; square brackets are kept for pronunciation; answer = the complete correct sentence, including any beginning the test gives (e.g. "Your bag is heavier than my bag."); accepted_answers = other wordings that are also correct and, when the test gives a beginning, the rest of the sentence on its own (e.g. "heavier than my bag").
        - matching: one question per left-hand item; prompt = that item; options = the whole right-hand column without letters (the same list for each item of the group); answer = its match, copied exactly.
        - pronunciation: "different pronunciation of the underlined part" or "different stress"; prompt = the instruction only, never the words; options = the words, each with its underlined letters in square brackets, e.g. ["b[oo]k", "l[oo]k", "f[oo]d"]; answer = the odd one out, copied exactly as in options, brackets included.

        Answers: use the test's answer key when it has one. Otherwise work out the answer yourself and set "needs_check": true.
        Also set "needs_check": true whenever the text is hard to read or you are unsure of anything in the question.
        A reading text, or a listening script, goes in "passage", transcribed exactly. If there is none, passage is null.
        Anything that fits no type above (audio without a script, pictures, speaking tasks, open writing) goes in "skipped" as a short description; do not force it into a type.
        Ignore any handwriting, and never copy a name or personal detail of anyone who appears to be a student.
        Set "looks_like_textbook" to true if this looks photographed from a published textbook or workbook (printed unit banners, publisher logos, book page layout).
        titles and instructions: short, in English and in Vietnamese, describing the test.

        Reply with JSON only, no markdown fence:
        {"title_en": "...", "title_vi": "...", "instructions_en": "...", "instructions_vi": "...", "passage": null,
         "questions": [{"type": "multiple_choice", "prompt": "...", "options": ["..."], "answer": "...", "accepted_answers": null, "explanation_vi": null, "needs_check": false}],
         "skipped": [], "looks_like_textbook": false}
        PROMPT;
    }
}
