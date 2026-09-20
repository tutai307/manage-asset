<?php

namespace App\Actions\Skills;

use App\Enums\QuestionType;
use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Exceptions\AiUnavailableException;
use App\Models\CurriculumUnit;
use App\Models\SkillExercise;
use App\Services\Ai\OpenRouterClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * AM-018/019/020: build one practice exercise for a unit and a skill.
 *
 * Everything is written fresh for the unit's own vocabulary and grammar point — nothing is taken
 * from the textbook (ADR-0005). The result is a draft until the teacher publishes it.
 */
class GenerateSkillExercise
{
    public function __construct(private readonly OpenRouterClient $ai) {}

    /**
     * @throws AiUnavailableException
     */
    public function handle(CurriculumUnit $unit, SkillType $skill): SkillExercise
    {
        $unit->loadMissing('vocabulary');

        $answer = $this->ai->chat([
            ['role' => 'system', 'content' => $this->systemPrompt($skill)],
            ['role' => 'user', 'content' => $this->brief($unit, $skill)],
        ], maxTokens: 1800, temperature: 0.4);

        $payload = $this->decode($answer, $skill);

        return DB::transaction(function () use ($unit, $skill, $payload) {
            $exercise = $unit->exercises()->create([
                'skill' => $skill,
                'title_en' => $payload['title_en'],
                'title_vi' => $payload['title_vi'],
                'instructions_vi' => $payload['instructions_vi'],
                'instructions_en' => $payload['instructions_en'],
                'passage' => $payload['passage'],
                'prompt_vi' => $payload['prompt_vi'],
                'prompt_en' => $payload['prompt_en'],
                'min_words' => $payload['min_words'],
                'status' => TopicStatus::Draft,
                'model' => (string) config('services.openrouter.model'),
                'sort_order' => $unit->exercises()->where('skill', $skill->value)->count() + 1,
            ]);

            foreach ($payload['questions'] as $i => $question) {
                $exercise->questions()->create([
                    'type' => $question['type'],
                    'prompt' => $question['prompt'],
                    'options' => $question['options'],
                    'answer' => $question['answer'],
                    'explanation_vi' => $question['explanation_vi'],
                    'sort_order' => $i + 1,
                ]);
            }

            return $exercise->load('questions');
        });
    }

    private function systemPrompt(SkillType $skill): string
    {
        $shared = <<<'PROMPT'
        You write English practice for Vietnamese lower-secondary students, for one unit of their course.

        Hard rules:
        - Use ONLY the unit's vocabulary and grammar point given below, plus words a student at this level already knows.
        - Write everything yourself. Never reproduce a text, exercise or recording from any textbook.
        - The setting is Vietnam: Vietnamese names, places, food, and dong for prices.
        - Reply with JSON only, no markdown fence.
        PROMPT;

        return $shared."\n\n".match ($skill) {
            SkillType::Reading => <<<'PROMPT'
            Write a short reading passage and comprehension questions.

            {
              "title_en": "...", "title_vi": "...",
              "instructions_en": "...", "instructions_vi": "...",
              "passage": "<80-130 words, 2 short paragraphs>",
              "questions": [
                {"type": "multiple_choice", "prompt": "...", "options": ["...", "...", "...", "..."], "answer": "<the correct option, copied exactly>", "explanation_vi": "<why, in one short Vietnamese sentence>"},
                {"type": "true_false", "prompt": "...", "options": ["True", "False"], "answer": "True", "explanation_vi": "..."},
                {"type": "gap_fill", "prompt": "<a sentence about the passage with ___ for the gap>", "options": null, "answer": "<one or two words>", "explanation_vi": "..."}
              ]
            }

            Give 5 questions: 3 multiple choice, 1 true/false, 1 gap fill. Every answer must be findable in the passage.
            PROMPT,
            SkillType::Listening => <<<'PROMPT'
            Write a short conversation that will be READ ALOUD by the browser, and questions about it.
            The student hears it and does not see the text, so keep it clear and simple.

            {
              "title_en": "...", "title_vi": "...",
              "instructions_en": "...", "instructions_vi": "...",
              "passage": "<a 6-10 line dialogue, each line starting with the speaker's name and a colon, 70-110 words total>",
              "questions": [
                {"type": "multiple_choice", "prompt": "...", "options": ["...", "...", "..."], "answer": "<the correct option, copied exactly>", "explanation_vi": "..."},
                {"type": "gap_fill", "prompt": "<sentence with ___>", "options": null, "answer": "<one or two words>", "explanation_vi": "..."}
              ]
            }

            Give 4 questions: 3 multiple choice and 1 gap fill. Ask only about things clearly said in the dialogue.
            PROMPT,
            SkillType::Writing => <<<'PROMPT'
            Write one writing task the student can do in 5-10 minutes.

            {
              "title_en": "...", "title_vi": "...",
              "instructions_en": "...", "instructions_vi": "...",
              "prompt_en": "<the task, with 3 bullet points of what to include, as plain lines starting with '- '>",
              "prompt_vi": "<the same task in Vietnamese>",
              "min_words": 50,
              "questions": []
            }
            PROMPT,
            SkillType::Speaking => <<<'PROMPT'
            Speaking practice is handled by the role-play feature; do not generate it here.
            PROMPT,
        };
    }

    private function brief(CurriculumUnit $unit, SkillType $skill): string
    {
        $words = $unit->vocabulary
            ->map(fn ($word) => $word->word.($word->part_of_speech ? " ({$word->part_of_speech})" : '').' = '.$word->meaning_vi)
            ->implode("\n- ");

        $level = match (true) {
            $unit->grade <= 6 => 'CEFR A1',
            $unit->grade <= 8 => 'CEFR A1-A2',
            default => 'CEFR A2',
        };

        return "Grade {$unit->grade}, Unit {$unit->number}: \"{$unit->title_en}\" ({$unit->title_vi}).\n"
            ."Skill: {$skill->value}. Level: {$level}.\n"
            .'Grammar point of this unit: '.($unit->grammar_en ?: 'not specified')."\n"
            ."Unit vocabulary (use these words):\n- {$words}";
    }

    /**
     * @return array<string, mixed>
     */
    private function decode(string $answer, SkillType $skill): array
    {
        $json = trim(preg_replace('/^```(?:json)?|```$/m', '', $answer));
        $payload = json_decode($json, true);

        if (! is_array($payload) || ! filled($payload['title_en'] ?? null)) {
            $this->fail($answer);
        }

        $questions = $this->questions($payload['questions'] ?? []);

        if ($skill->usesPassage() && (! filled($payload['passage'] ?? null) || count($questions) < 3)) {
            $this->fail($answer);
        }

        if ($skill === SkillType::Writing && ! filled($payload['prompt_en'] ?? null)) {
            $this->fail($answer);
        }

        return [
            'title_en' => mb_substr(trim($payload['title_en']), 0, 150),
            'title_vi' => mb_substr(trim($payload['title_vi'] ?? $payload['title_en']), 0, 150),
            'instructions_en' => mb_substr(trim($payload['instructions_en'] ?? ''), 0, 300),
            'instructions_vi' => mb_substr(trim($payload['instructions_vi'] ?? ''), 0, 300),
            'passage' => filled($payload['passage'] ?? null) ? trim($payload['passage']) : null,
            'prompt_en' => filled($payload['prompt_en'] ?? null) ? trim($payload['prompt_en']) : null,
            'prompt_vi' => filled($payload['prompt_vi'] ?? null) ? trim($payload['prompt_vi']) : null,
            'min_words' => $skill === SkillType::Writing ? max(30, min(150, (int) ($payload['min_words'] ?? 50))) : null,
            'questions' => $questions,
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function questions(array $raw): array
    {
        $questions = [];

        foreach ($raw as $item) {
            if (! is_array($item) || ! filled($item['prompt'] ?? null) || ! filled($item['answer'] ?? null)) {
                continue;
            }

            $type = QuestionType::tryFrom((string) ($item['type'] ?? '')) ?? QuestionType::MultipleChoice;
            $options = is_array($item['options'] ?? null)
                ? array_values(array_filter(array_map(fn ($o) => is_string($o) ? trim($o) : null, $item['options'])))
                : null;

            // A choice question whose answer is not among its options would be unanswerable.
            if ($type->hasOptions() && (! $options || ! in_array(trim($item['answer']), $options, true))) {
                continue;
            }

            $questions[] = [
                'type' => $type,
                'prompt' => mb_substr(trim($item['prompt']), 0, 500),
                'options' => $type->hasOptions() ? $options : null,
                'answer' => mb_substr(trim($item['answer']), 0, 200),
                'explanation_vi' => filled($item['explanation_vi'] ?? null) ? mb_substr(trim($item['explanation_vi']), 0, 300) : null,
            ];
        }

        return $questions;
    }

    private function fail(string $answer): never
    {
        Log::warning('Skill exercise could not be parsed', ['answer' => mb_substr($answer, 0, 500)]);

        throw new AiUnavailableException('The exercise could not be parsed.');
    }
}
