<?php

namespace App\Livewire\Assignments;

use App\Actions\Assignments\AssignExercise;
use App\Exceptions\ExerciseNotReadyException;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\SkillExercise;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * AM-028: give the exercise on screen to the teacher's classes, and see where it is assigned.
 */
class AssignPanel extends Component
{
    #[Locked]
    public int $exerciseId;

    /** @var list<int> */
    public array $classroomIds = [];

    /** Local date and time, in the display timezone. */
    public string $dueAt = '';

    public ?string $error = null;

    public function mount(int $exerciseId): void
    {
        $this->exerciseId = $exerciseId;
        Gate::authorize('assign', $this->exercise());
    }

    public function assign(AssignExercise $assignExercise): void
    {
        $exercise = $this->exercise();
        Gate::authorize('assign', $exercise);

        $this->error = null;

        $this->validate([
            'classroomIds' => ['required', 'array', 'min:1'],
            'classroomIds.*' => ['integer', Rule::exists('classrooms', 'id')],
            'dueAt' => ['nullable', 'date', 'after:now'],
        ], messages: [
            'classroomIds.required' => __('assignments.pick_class'),
        ], attributes: ['dueAt' => __('assignments.due')]);

        $classrooms = Classroom::query()->visibleTo(auth()->user())->whereIn('id', $this->classroomIds)->get();
        $classrooms->each(fn (Classroom $classroom) => Gate::authorize('update', $classroom));

        $due = filled($this->dueAt) ? Carbon::parse($this->dueAt, config('app.display_timezone'))->utc() : null;

        try {
            $assigned = $assignExercise->handle(auth()->user(), $exercise, $classrooms, $due);
        } catch (ExerciseNotReadyException $e) {
            $this->error = __($e->getMessage());

            return;
        }

        $this->reset('classroomIds', 'dueAt');
        $this->dispatch('notify', message: __('assignments.assigned', ['count' => $assigned->count()]));
    }

    public function unassign(int $assignmentId): void
    {
        $assignment = Assignment::query()->with('classroom')->where('skill_exercise_id', $this->exerciseId)->findOrFail($assignmentId);
        Gate::authorize('delete', $assignment);

        $assignment->delete();
        $this->dispatch('notify', message: __('assignments.unassigned', ['class' => $assignment->classroom->name]));
    }

    public function render()
    {
        $user = auth()->user();

        return view('livewire.assignments.assign-panel', [
            'classrooms' => Classroom::query()->visibleTo($user)->orderBy('name')->get(['id', 'name', 'grade']),
            'assignments' => Assignment::query()
                ->where('skill_exercise_id', $this->exerciseId)
                ->whereHas('classroom', fn ($q) => $q->visibleTo($user))
                ->with('classroom:id,name')
                ->orderBy('id')
                ->get(),
        ]);
    }

    private function exercise(): SkillExercise
    {
        return SkillExercise::query()->findOrFail($this->exerciseId);
    }
}
