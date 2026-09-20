<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;

class ClassroomPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->canTeach();
    }

    public function view(User $user, Classroom $classroom): bool
    {
        return $this->owns($user, $classroom);
    }

    public function create(User $user): bool
    {
        return $user->role->canTeach();
    }

    public function update(User $user, Classroom $classroom): bool
    {
        return $this->owns($user, $classroom);
    }

    /**
     * Add student accounts to the class or reset their passwords.
     */
    public function manageStudents(User $user, Classroom $classroom): bool
    {
        return $this->owns($user, $classroom);
    }

    private function owns(User $user, Classroom $classroom): bool
    {
        if (! $user->role->canTeach()) {
            return false;
        }

        return $user->role->seesEverything() || $classroom->teacher_id === $user->id;
    }
}
