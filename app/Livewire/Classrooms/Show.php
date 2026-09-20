<?php

namespace App\Livewire\Classrooms;

use App\Actions\Classrooms\CreateStudentAccounts;
use App\Actions\Classrooms\ResetStudentPassword;
use App\Models\Classroom;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    #[Locked]
    public int $classroomId;

    /** One student name per line. */
    public string $studentNames = '';

    /**
     * Credentials created in this page visit, shown once for printing.
     *
     * @var list<array{name: string, username: string, password: string}>
     */
    public array $credentials = [];

    public function mount(Classroom $classroom): void
    {
        Gate::authorize('view', $classroom);

        $this->classroomId = $classroom->id;
    }

    public function addStudents(CreateStudentAccounts $createStudentAccounts): void
    {
        $classroom = $this->classroom();
        Gate::authorize('manageStudents', $classroom);

        $this->validate(
            ['studentNames' => ['required', 'string', 'max:5000']],
            attributes: ['studentNames' => __('classrooms.student_names')],
        );

        $names = collect(preg_split('/\R/u', $this->studentNames))
            ->map(fn (string $name) => trim(preg_replace('/\s+/u', ' ', $name)))
            ->filter()
            ->values();

        if ($names->contains(fn (string $name) => mb_strlen($name) > 100)) {
            $this->addError('studentNames', __('classrooms.name_too_long'));

            return;
        }

        if ($names->count() > 60) {
            $this->addError('studentNames', __('classrooms.too_many_students'));

            return;
        }

        $this->credentials = array_merge($this->credentials, $createStudentAccounts->handle($classroom, $names->all()));
        $this->reset('studentNames');
        $this->dispatch('notify', message: __('classrooms.students_added', ['count' => $names->count()]));
    }

    public function resetPassword(int $studentId, ResetStudentPassword $resetStudentPassword): void
    {
        $classroom = $this->classroom();
        Gate::authorize('manageStudents', $classroom);

        $student = $classroom->students()->findOrFail($studentId);

        $this->credentials[] = [
            'name' => $student->name,
            'username' => $student->username,
            'password' => $resetStudentPassword->handle($student),
        ];

        $this->dispatch('notify', message: __('classrooms.password_reset', ['name' => $student->name]));
    }

    public function render()
    {
        $classroom = $this->classroom();

        return view('livewire.classrooms.show', [
            'classroom' => $classroom,
            'students' => $classroom->students()->orderBy('name')->paginate(50),
        ])->title(__('classrooms.class_name', ['name' => $classroom->name]));
    }

    private function classroom(): Classroom
    {
        return Classroom::query()->findOrFail($this->classroomId);
    }
}
