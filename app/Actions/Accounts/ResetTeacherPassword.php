<?php

namespace App\Actions\Accounts;

use App\Models\User;
use Illuminate\Support\Str;

class ResetTeacherPassword
{
    /**
     * @return string the new plain-text password, shown to the administrator once
     */
    public function handle(User $teacher): string
    {
        $password = Str::password(12, symbols: false);

        $teacher->update(['password' => $password]);

        return $password;
    }
}
