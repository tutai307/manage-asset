<?php

namespace App\Actions\Assignments;

use App\Enums\SkillType;
use App\Exceptions\ExerciseNotReadyException;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\SkillExercise;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AssignExercise
{
    /**
     * Give an exercise to classes, with an optional due date. Assigning again to a class that
     * already has it only moves the due date. Assigning is the teacher's approval: it shows the
     * exercise to that class only, never to the rest of the grade.
     *
     * @param  Collection<int, Classroom>  $classrooms  already checked as the teacher's own
     * @return Collection<int, Assignment>
     *
     * @throws ExerciseNotReadyException
     */
    public function handle(User $teacher, SkillExercise $exercise, Collection $classrooms, ?CarbonInterface $dueAt): Collection
    {
        if ($exercise->skill !== SkillType::Writing && ! $exercise->questions()->exists()) {
            throw new ExerciseNotReadyException('assignments.needs_questions');
        }

        // Questions read from an upload must have been checked (saved) by the teacher first.
        if ($exercise->questions()->where('needs_check', true)->exists()) {
            throw new ExerciseNotReadyException('assignments.needs_review');
        }

        return DB::transaction(function () use ($teacher, $exercise, $classrooms, $dueAt) {
            return $classrooms->map(fn (Classroom $classroom) => Assignment::updateOrCreate(
                ['skill_exercise_id' => $exercise->id, 'classroom_id' => $classroom->id],
                ['assigned_by' => $teacher->id, 'due_at' => $dueAt],
            ));
        });
    }
}
