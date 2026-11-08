<?php

namespace App\Livewire\Skills;

use App\Actions\Skills\SaveSkillExercise;
use App\Enums\QuestionType;
use App\Enums\SkillType;
use App\Models\ExerciseQuestion;
use App\Models\SkillExercise;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class EditExercise extends Component
{
    #[Locked]
    public int $exerciseId;

    public string $titleVi = '';

    public string $titleEn = '';

    public string $instructionsVi = '';

    public string $instructionsEn = '';

    public string $passage = '';

    public string $promptVi = '';

    public string $promptEn = '';

    public ?int $minWords = null;

    /** @var list<array{id: ?int, type: string, prompt: string, options: string, answer: string, accepted_answers: string, explanation_vi: string, needs_check: bool}> */
    public array $questions = [];

    public function mount(SkillExercise $exercise): void
    {
        Gate::authorize('update', $exercise);

        $this->exerciseId = $exercise->id;
        $this->titleVi = $exercise->title_vi;
        $this->titleEn = $exercise->title_en;
        $this->instructionsVi = $exercise->instructions_vi;
        $this->instructionsEn = $exercise->instructions_en;
        $this->passage = (string) $exercise->passage;
        $this->promptVi = (string) $exercise->prompt_vi;
        $this->promptEn = (string) $exercise->prompt_en;
        $this->minWords = $exercise->min_words;

        $this->questions = $exercise->questions->map(fn ($question) => [
            'id' => $question->id,
            'type' => $question->type->value,
            'prompt' => $question->prompt,
            'options' => implode("\n", $question->options ?? []),
            'answer' => $question->answer,
            'accepted_answers' => implode('
', $question->accepted_answers ?? []),
            'explanation_vi' => (string) $question->explanation_vi,
            'needs_check' => $question->needs_check,
        ])->all();
    }

    public function addQuestion(): void
    {
        $this->questions[] = [
            'id' => null,
            'type' => QuestionType::MultipleChoice->value,
            'prompt' => '',
            'options' => '',
            'answer' => '',
            'accepted_answers' => '',
            'explanation_vi' => '',
            'needs_check' => false,
        ];
    }

    public function removeQuestion(int $index): void
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function save(SaveSkillExercise $saveSkillExercise): void
    {
        $exercise = $this->exercise();
        Gate::authorize('update', $exercise);

        $validated = $this->validate($this->rules($exercise), attributes: $this->attributeNames());

        $questions = [];

        foreach ($validated['questions'] ?? [] as $index => $question) {
            $type = QuestionType::from($question['type']);
            $options = $type->hasOptions() ? $this->lines($question['options']) : null;

            if ($type->hasOptions() && ! in_array(trim($question['answer']), $options, true)) {
                $this->addError("questions.{$index}.answer", __('skills.answer_not_in_options'));

                return;
            }

            if ($type === QuestionType::Reorder && ! $this->usesTheSameWords($question['prompt'], $question['answer'])) {
                $this->addError("questions.{$index}.answer", __('skills.reorder_mismatch'));

                return;
            }

            $questions[] = [
                'id' => $question['id'] ?? null,
                'type' => $question['type'],
                'prompt' => trim($question['prompt']),
                'options' => $options,
                'answer' => trim($question['answer']),
                'accepted_answers' => $type->acceptsAlternatives() ? ($this->lines($question['accepted_answers'] ?? '') ?: null) : null,
                'explanation_vi' => filled($question['explanation_vi'] ?? null) ? trim($question['explanation_vi']) : null,
            ];
        }

        $saveSkillExercise->handle($exercise, [
            'title_vi' => trim($validated['titleVi']),
            'title_en' => trim($validated['titleEn']),
            'instructions_vi' => trim($validated['instructionsVi']),
            'instructions_en' => trim($validated['instructionsEn']),
            'passage' => $exercise->skill->usesPassage() || $exercise->skill === SkillType::Language ? (trim((string) $validated['passage']) ?: null) : null,
            'prompt_vi' => $exercise->skill === SkillType::Writing ? trim($validated['promptVi']) : null,
            'prompt_en' => $exercise->skill === SkillType::Writing ? trim($validated['promptEn']) : null,
            'min_words' => $exercise->skill === SkillType::Writing ? $validated['minWords'] : null,
        ], $questions);

        session()->flash('status', __('skills.saved'));

        $this->redirectRoute('exercises.show', $this->exerciseId, navigate: false);
    }

    public function render()
    {
        $exercise = $this->exercise();

        return view('livewire.skills.edit-exercise', [
            'exercise' => $exercise,
            'questionTypes' => QuestionType::cases(),
            'originalsExist' => collect($exercise->source_files['files'] ?? [])->map(fn (string $path) => Storage::disk('local')->exists($path))->all(),
        ])->title(__('skills.edit').' · '.$exercise->title());
    }

    private function rules(SkillExercise $exercise): array
    {
        return [
            'titleVi' => ['required', 'string', 'max:150'],
            'titleEn' => ['required', 'string', 'max:150'],
            'instructionsVi' => ['required', 'string', 'max:300'],
            'instructionsEn' => ['required', 'string', 'max:300'],
            'passage' => [$exercise->skill->usesPassage() ? 'required' : 'nullable', 'string', 'max:4000'],
            'promptVi' => [$exercise->skill === SkillType::Writing ? 'required' : 'nullable', 'string', 'max:2000'],
            'promptEn' => [$exercise->skill === SkillType::Writing ? 'required' : 'nullable', 'string', 'max:2000'],
            'minWords' => [$exercise->skill === SkillType::Writing ? 'required' : 'nullable', 'integer', 'between:20,300'],
            'questions' => $exercise->skill === SkillType::Writing ? ['array'] : ['array', 'min:1'],
            'questions.*.id' => ['nullable', 'integer'],
            'questions.*.type' => ['required', Rule::in(array_column(QuestionType::cases(), 'value'))],
            'questions.*.prompt' => ['required', 'string', 'max:500'],
            'questions.*.options' => ['nullable', 'string', 'max:1000'],
            'questions.*.answer' => ['required', 'string', 'max:200'],
            'questions.*.accepted_answers' => ['nullable', 'string', 'max:1000'],
            'questions.*.explanation_vi' => ['nullable', 'string', 'max:300'],
        ];
    }

    private function attributeNames(): array
    {
        return [
            'titleVi' => __('skills.title_vi'),
            'titleEn' => __('skills.title_en'),
            'instructionsVi' => __('skills.instructions'),
            'instructionsEn' => __('skills.instructions'),
            'passage' => __('skills.passage'),
            'promptVi' => __('skills.task'),
            'promptEn' => __('skills.task'),
            'minWords' => __('skills.min_word_count'),
        ];
    }

    /**
     * A reorder answer must use exactly the words it gives the student, or nobody can get it right.
     */
    private function usesTheSameWords(string $prompt, string $answer): bool
    {
        $words = fn (string $text) => collect(preg_split('/[\s\/]+/u', ExerciseQuestion::normalise(str_replace('/', ' ', $text)), -1, PREG_SPLIT_NO_EMPTY))->sort()->values()->all();

        return $words($prompt) === $words($answer);
    }

    /**
     * @return list<string>
     */
    private function lines(?string $value): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/u', (string) $value))));
    }

    private function exercise(): SkillExercise
    {
        return SkillExercise::query()->with('questions')->findOrFail($this->exerciseId);
    }
}
