<?php

namespace App\Livewire\Teachers;

use App\Actions\Accounts\ResetTeacherPassword;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    /**
     * Passwords created in this page visit, shown once.
     *
     * @var list<array{name: string, username: string, password: string}>
     */
    public array $credentials = [];

    public function mount(): void
    {
        Gate::authorize('manageTeachers', User::class);
    }

    public function resetPassword(int $teacherId, ResetTeacherPassword $resetTeacherPassword): void
    {
        $teacher = User::query()->findOrFail($teacherId);
        Gate::authorize('resetTeacherPassword', $teacher);

        $this->credentials[] = [
            'name' => $teacher->name,
            'username' => $teacher->username,
            'password' => $resetTeacherPassword->handle($teacher),
        ];

        $this->dispatch('notify', message: __('teachers.password_reset', ['name' => $teacher->name]));
    }

    public function render()
    {
        Gate::authorize('manageTeachers', User::class);

        return view('livewire.teachers.index', [
            'teachers' => User::query()->where('role', UserRole::Teacher->value)->orderBy('name')->paginate(20),
        ])->title(__('teachers.title'));
    }
}
