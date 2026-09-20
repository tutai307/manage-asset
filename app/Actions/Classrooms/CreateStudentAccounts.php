<?php

namespace App\Actions\Classrooms;

use App\Enums\UserRole;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateStudentAccounts
{
    /**
     * Create one student account per name and enrol them in the class.
     *
     * Initial passwords are returned in plain text exactly once so the teacher can print them;
     * only the hash is stored.
     *
     * @param  list<string>  $names
     * @return list<array{name: string, username: string, password: string}>
     */
    public function handle(Classroom $classroom, array $names): array
    {
        return DB::transaction(function () use ($classroom, $names) {
            $credentials = [];

            foreach ($names as $name) {
                $password = self::generatePassword();

                $student = User::create([
                    'name' => $name,
                    'username' => $this->uniqueUsername($name),
                    'password' => $password,
                    'role' => UserRole::Student,
                ]);

                $classroom->students()->attach($student->id);

                $credentials[] = ['name' => $name, 'username' => $student->username, 'password' => $password];
            }

            return $credentials;
        });
    }

    /**
     * Short, readable password without ambiguous characters (0/O, 1/l/I).
     */
    public static function generatePassword(): string
    {
        $alphabet = 'abcdefghjkmnpqrstuvwxyz23456789';

        return collect(range(1, 8))
            ->map(fn () => $alphabet[random_int(0, strlen($alphabet) - 1)])
            ->implode('');
    }

    /**
     * "Nguyễn Văn An" → "hs.nguyenvanan", then "hs.nguyenvanan2", … if taken (including soft-deleted accounts).
     */
    private function uniqueUsername(string $name): string
    {
        $base = 'hs.'.(Str::slug(Str::ascii($name), '') ?: 'hocsinh');
        $base = Str::limit($base, 45, '');

        $taken = User::withTrashed()
            ->where('username', 'like', $base.'%')
            ->pluck('username')
            ->all();

        if (! in_array($base, $taken, true)) {
            return $base;
        }

        $suffix = 2;

        while (in_array($base.$suffix, $taken, true)) {
            $suffix++;
        }

        return $base.$suffix;
    }
}
