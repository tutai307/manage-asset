<?php

namespace App\Livewire\Classrooms;

use App\Models\Classroom;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $name = '';

    public ?int $grade = null;

    public function mount(): void
    {
        Gate::authorize('viewAny', Classroom::class);
    }

    protected function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'max:50',
                Rule::unique('classrooms', 'name')
                    ->where('teacher_id', auth()->id())
                    ->whereNull('deleted_at'),
            ],
            'grade' => ['nullable', 'integer', 'between:6,9'],
        ];
    }

    protected function messages(): array
    {
        return ['name.unique' => __('classrooms.duplicate')];
    }

    public function create(): void
    {
        Gate::authorize('create', Classroom::class);

        $validated = $this->validate();

        $classroom = auth()->user()->taughtClassrooms()->create([
            'name' => trim($validated['name']),
            'grade' => $validated['grade'],
        ]);

        $this->reset('name', 'grade');
        $this->dispatch('notify', message: __('classrooms.created', ['name' => $classroom->name]));
    }

    public function render()
    {
        $classrooms = Classroom::query()
            ->visibleTo(auth()->user())
            ->with('teacher')
            ->withCount('students')
            ->orderBy('name')
            ->paginate(25);

        return view('livewire.classrooms.index', ['classrooms' => $classrooms])
            ->title(__('classrooms.title'));
    }
}
