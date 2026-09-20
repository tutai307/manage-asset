<?php

namespace App\Livewire\Skills;

use App\Actions\Skills\SubmitExerciseAttempt;
use App\Enums\SkillType;
use App\Exceptions\AiUnavailableException;
use App\Models\ExerciseAttempt;
use App\Models\SkillExercise;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ExercisePage extends Component
{
    #[Locked]
    public int $exerciseId;

    /** @var array<int, string> question id => answer */
    public array $answers = [];

    public string $written = '';

    public ?string $error = null;

    #[Locked]
    public ?int $attemptId = null;

    public function mount(SkillExercise $exercise): void
    {
        Gate::authorize('view', $exercise);

        $this->exerciseId = $exercise->id;
    }

    public function submit(SubmitExerciseAttempt $submitExerciseAttempt): void
    {
        $exercise = $this->exercise();
        Gate::authorize('attempt', $exercise);

        $this->error = null;

        if ($exercise->skill === SkillType::Writing) {
            $this->validate(
                ['written' => ['required', 'string', 'min:20', 'max:4000']],
                attributes: ['written' => __('skills.your_writing')],
            );
        } elseif (count(array_filter($this->answers, fn ($a) => filled($a))) < $exercise->questions()->count()) {
            $this->error = __('skills.answer_all');

            return;
        }

        try {
            $attempt = $submitExerciseAttempt->handle(auth()->user(), $exercise, $this->answers, $this->written);
        } catch (AiUnavailableException) {
            $this->error = __('skills.marking_failed');

            return;
        }

        $this->attemptId = $attempt->id;
    }

    public function tryAgain(): void
    {
        $this->reset('answers', 'written', 'attemptId', 'error');
    }

    public function render()
    {
        $exercise = $this->exercise();
        $attempt = $this->attemptId ? ExerciseAttempt::find($this->attemptId) : null;

        return view('livewire.skills.exercise-page', [
            'exercise' => $exercise,
            'attempt' => $attempt,
            'canAttempt' => auth()->user()->can('attempt', $exercise),
            'previousAttempts' => ExerciseAttempt::query()
                ->where('user_id', auth()->id())
                ->where('skill_exercise_id', $exercise->id)
                ->when($this->attemptId, fn ($q) => $q->whereKeyNot($this->attemptId))
                ->latest('id')
                ->limit(3)
                ->get(),
        ])->title($exercise->title());
    }

    private function exercise(): SkillExercise
    {
        return SkillExercise::query()->with('questions')->findOrFail($this->exerciseId);
    }
}
