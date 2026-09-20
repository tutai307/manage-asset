<?php

namespace App\Actions\Classrooms;

use App\Models\User;

class ResetStudentPassword
{
    /**
     * @return string the new plain-text password, shown to the teacher once
     */
    public function handle(User $student): string
    {
        $password = CreateStudentAccounts::generatePassword();

        $student->update(['password' => $password]);

        return $password;
    }
}
