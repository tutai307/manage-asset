<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    public function manageTeachers(User $user): bool
    {
        return $user->role->seesEverything();
    }

    public function resetTeacherPassword(User $user, User $target): bool
    {
        return $user->role->seesEverything() && $target->role === UserRole::Teacher;
    }
}
