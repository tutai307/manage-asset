<?php

namespace App\Actions\Accounts;

use App\Models\User;

class ChangeOwnPassword
{
    public function handle(User $user, string $newPassword): void
    {
        $user->update(['password' => $newPassword]);
    }
}
