<?php

namespace App\Livewire\Assignments;

use App\Models\Assignment;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * AM-028: who in the class has done the assigned exercise, and how well.
 */
class Show extends Component
{
    use WithPagination;

    #[Locked]
    public int $assignmentId;

    public function mount(Assignment $assignment): void
    {
        Gate::authorize('view', $assignment);

        $this->assignmentId = $assignment->id;
    }

    public function render()
    {
        $assignment = Assignment::query()->with(['exercise', 'classroom'])->findOrFail($this->assignmentId);
        Gate::authorize('view', $assignment);

        $attemptsOnThis = fn ($query) => $query->where('skill_exercise_id', $assignment->skill_exercise_id);

        $students = $assignment->classroom->students()
            ->withCount(['exerciseAttempts as attempts_count' => $attemptsOnThis])
            ->withMax(['exerciseAttempts as best_score' => $attemptsOnThis], 'score')
            ->withMax(['exerciseAttempts as max_score' => $attemptsOnThis], 'max_score')
            ->withMin(['exerciseAttempts as first_at' => $attemptsOnThis], 'created_at')
            ->withMax(['exerciseAttempts as last_at' => $attemptsOnThis], 'created_at')
            ->orderBy('name')
            ->paginate(50);

        $summary = $assignment->classroom->students()
            ->whereHas('exerciseAttempts', $attemptsOnThis)
            ->withMax(['exerciseAttempts as best_score' => $attemptsOnThis], 'score')
            ->get()
            ->pipe(fn ($done) => [
                'done' => $done->count(),
                'average' => $done->isEmpty() ? null : round($done->avg('best_score'), 1),
            ]);

        return view('livewire.assignments.show', [
            'assignment' => $assignment,
            'students' => $students,
            'total' => $assignment->classroom->students()->count(),
            'summary' => $summary,
        ])->title(__('assignments.results').' · '.$assignment->exercise->title());
    }
}
