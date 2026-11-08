<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;

class AssignmentPolicy
{
    /**
     * A teacher sees results only for their own classes; an administrator for every class.
     */
    public function view(User $user, Assignment $assignment): bool
    {
        return $this->ownsClass($user, $assignment);
    }

    public function delete(User $user, Assignment $assignment): bool
    {
        return $this->ownsClass($user, $assignment);
    }

    private function ownsClass(User $user, Assignment $assignment): bool
    {
        if (! $user->role->canTeach()) {
            return false;
        }

        return $user->role->seesEverything() || $assignment->classroom->teacher_id === $user->id;
    }
}
