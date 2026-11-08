<?php

namespace App\Policies;

use App\Models\SkillExercise;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SkillExercisePolicy
{
    /**
     * Same rule as the lists (SkillExercise::scopeVisibleTo). Students must not learn that an
     * exercise they cannot open exists.
     */
    public function view(User $user, SkillExercise $exercise): Response
    {
        return $this->visible($user, $exercise) ? Response::allow() : Response::denyAsNotFound();
    }

    public function create(User $user): bool
    {
        return $user->role->canTeach();
    }

    /**
     * Open unit practice is shared by all teachers; a teacher's own exercise is theirs to edit.
     */
    public function update(User $user, SkillExercise $exercise): bool
    {
        if (! $user->role->canTeach()) {
            return false;
        }

        return $user->role->seesEverything() || ! $exercise->isTeacherOwned() || $exercise->owner_id === $user->id;
    }

    /**
     * A teacher deletes their own exercises, and unreviewed drafts that belong to nobody. The
     * shipped open practice is kept.
     */
    public function delete(User $user, SkillExercise $exercise): bool
    {
        if (! $user->role->canTeach()) {
            return false;
        }

        return $user->role->seesEverything()
            || $exercise->owner_id === $user->id
            || (! $exercise->isTeacherOwned() && ! $exercise->status->isVisibleToStudents());
    }

    /**
     * Give the exercise to a class. Which classes is checked per class (ClassroomPolicy::update).
     */
    public function assign(User $user, SkillExercise $exercise): bool
    {
        return $user->role->canTeach() && $this->visible($user, $exercise);
    }

    /**
     * Only students hand in answers; a teacher opening an exercise is previewing it.
     */
    public function attempt(User $user, SkillExercise $exercise): bool
    {
        return ! $user->role->canTeach() && $this->visible($user, $exercise);
    }

    private function visible(User $user, SkillExercise $exercise): bool
    {
        return SkillExercise::query()->visibleTo($user)->whereKey($exercise->id)->exists();
    }
}
