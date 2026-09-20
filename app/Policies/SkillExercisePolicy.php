<?php

namespace App\Policies;

use App\Models\SkillExercise;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SkillExercisePolicy
{
    /**
     * Students must not learn that an unpublished exercise exists.
     */
    public function view(User $user, SkillExercise $exercise): Response
    {
        if ($user->role->canTeach() || $exercise->status->isVisibleToStudents()) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }

    public function create(User $user): bool
    {
        return $user->role->canTeach();
    }

    public function update(User $user, SkillExercise $exercise): bool
    {
        return $user->role->canTeach();
    }

    /**
     * Only students hand in answers; a teacher opening an exercise is previewing it.
     */
    public function attempt(User $user, SkillExercise $exercise): bool
    {
        return ! $user->role->canTeach() && $exercise->status->isVisibleToStudents();
    }
}
