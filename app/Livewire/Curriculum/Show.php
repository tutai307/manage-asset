<?php

namespace App\Livewire\Curriculum;

use App\Actions\Curriculum\GenerateUnitTopic;
use App\Actions\Curriculum\SaveUnitFocus;
use App\Actions\Curriculum\SuggestUnitFocus;
use App\Actions\Skills\GenerateSkillExercise;
use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Exceptions\AiUnavailableException;
use App\Models\CurriculumUnit;
use App\Models\SkillExercise;
use App\Models\Topic;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Show extends Component
{
    #[Locked]
    public int $unitId;

    public ?string $error = null;

    /** Teacher's editable view of what this unit teaches. */
    public string $vocabularyText = '';

    public string $grammarEn = '';

    public string $grammarVi = '';

    public bool $editingFocus = false;

    public function mount(CurriculumUnit $unit): void
    {
        $this->unitId = $unit->id;
        $this->fillFocusForm($unit);
    }

    // --- What the unit teaches -------------------------------------------------------------

    public function editFocus(): void
    {
        Gate::authorize('create', Topic::class);

        $this->fillFocusForm($this->unit());
        $this->editingFocus = true;
    }

    public function suggestFocus(SuggestUnitFocus $suggestUnitFocus): void
    {
        Gate::authorize('create', Topic::class);

        $this->error = null;

        try {
            $suggestion = $suggestUnitFocus->handle($this->unit());
        } catch (AiUnavailableException) {
            $this->error = __('curriculum.focus_suggest_failed');

            return;
        }

        $this->vocabularyText = $suggestion['vocabulary'];
        $this->grammarEn = $suggestion['grammar_en'];
        $this->grammarVi = $suggestion['grammar_vi'];
        $this->editingFocus = true;

        $this->dispatch('notify', message: __('curriculum.focus_suggested'));
    }

    public function saveFocus(SaveUnitFocus $saveUnitFocus): void
    {
        Gate::authorize('create', Topic::class);

        $this->validate(
            ['vocabularyText' => ['required', 'string', 'max:8000']],
            attributes: ['vocabularyText' => __('curriculum.vocabulary')],
        );

        $count = $saveUnitFocus->handle($this->unit(), $this->vocabularyText, $this->grammarEn, $this->grammarVi);

        if ($count === 0) {
            $this->addError('vocabularyText', __('curriculum.vocabulary_unreadable'));

            return;
        }

        $this->editingFocus = false;
        $this->dispatch('notify', message: __('curriculum.focus_saved', ['count' => $count]));
    }

    public function cancelFocus(): void
    {
        $this->fillFocusForm($this->unit());
        $this->editingFocus = false;
    }

    // --- Content ---------------------------------------------------------------------------

    public function generate(GenerateUnitTopic $generateUnitTopic): void
    {
        Gate::authorize('create', Topic::class);

        $this->error = null;

        try {
            $topic = $generateUnitTopic->handle($this->unit());
        } catch (AiUnavailableException) {
            $this->error = __('curriculum.generate_failed');

            return;
        }

        $this->dispatch('notify', message: __('curriculum.generated', ['title' => $topic->title_en]));
    }

    /**
     * Build one exercise for a skill. Refused until the teacher has confirmed the unit's
     * vocabulary, otherwise "aligned to the book" would be guesswork.
     */
    public function generateExercise(string $skill, GenerateSkillExercise $generateSkillExercise): void
    {
        Gate::authorize('create', SkillExercise::class);

        $this->error = null;
        $unit = $this->unit();
        $type = SkillType::from($skill);

        if ($type === SkillType::Speaking) {
            $this->error = __('skills.speaking_is_roleplay');

            return;
        }

        if (! $unit->hasApprovedFocus()) {
            $this->error = __('curriculum.focus_required');

            return;
        }

        try {
            $exercise = $generateSkillExercise->handle($unit, $type);
        } catch (AiUnavailableException) {
            $this->error = __('skills.generate_failed');

            return;
        }

        $this->dispatch('notify', message: __('skills.generated', ['title' => $exercise->title_en]));
    }

    public function publish(int $topicId): void
    {
        $topic = $this->unit()->topics()->findOrFail($topicId);
        Gate::authorize('update', $topic);

        $topic->update(['status' => TopicStatus::Published]);
        $this->dispatch('notify', message: __('curriculum.published'));
    }

    public function unpublish(int $topicId): void
    {
        $topic = $this->unit()->topics()->findOrFail($topicId);
        Gate::authorize('update', $topic);

        $topic->update(['status' => TopicStatus::Draft]);
        $this->dispatch('notify', message: __('curriculum.unpublished'));
    }

    public function publishExercise(int $exerciseId): void
    {
        $exercise = $this->unit()->exercises()->findOrFail($exerciseId);
        Gate::authorize('update', $exercise);

        $exercise->update(['status' => TopicStatus::Published]);
        $this->dispatch('notify', message: __('curriculum.published'));
    }

    public function unpublishExercise(int $exerciseId): void
    {
        $exercise = $this->unit()->exercises()->findOrFail($exerciseId);
        Gate::authorize('update', $exercise);

        $exercise->update(['status' => TopicStatus::Draft]);
        $this->dispatch('notify', message: __('curriculum.unpublished'));
    }

    public function render()
    {
        $user = auth()->user();
        $unit = $this->unit()->load('vocabulary');

        $topics = $unit->topics()
            ->visibleTo($user)
            ->withCount(['sentencePatterns', 'roleplayScenarios'])
            ->orderBy('sort_order')
            ->get();

        $exercises = $unit->exercises()
            ->visibleTo($user)
            ->withCount('questions')
            ->get()
            ->groupBy(fn (SkillExercise $exercise) => $exercise->skill->value);

        return view('livewire.curriculum.show', [
            'unit' => $unit,
            'topics' => $topics,
            'exercises' => $exercises,
            'skills' => SkillType::cases(),
            'canManage' => $user->can('create', Topic::class),
        ])->title($unit->label().' · '.$unit->title());
    }

    private function fillFocusForm(CurriculumUnit $unit): void
    {
        $this->vocabularyText = $unit->vocabulary
            ->map(fn ($word) => $word->word.($word->part_of_speech ? " ({$word->part_of_speech})" : '').' = '.$word->meaning_vi)
            ->implode("\n");
        $this->grammarEn = (string) $unit->grammar_en;
        $this->grammarVi = (string) $unit->grammar_vi;
    }

    private function unit(): CurriculumUnit
    {
        return CurriculumUnit::query()->findOrFail($this->unitId);
    }
}
