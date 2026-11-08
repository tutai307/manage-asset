<?php

namespace App\Livewire\Assignments;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * AM-028: a student's assigned exercises, or the assignments a teacher has given.
 */
class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $user = auth()->user();

        return $user->role->canTeach()
            ? view('livewire.assignments.teacher-index', ['assignments' => $this->forTeacher($user)])->title(__('assignments.teacher_title'))
            : view('livewire.assignments.student-index', ['assignments' => $this->forStudent($user)])->title(__('assignments.student_title'));
    }

    private function forTeacher(User $teacher)
    {
        $students = DB::table('classroom_user')
            ->join('users', 'users.id', '=', 'classroom_user.user_id')
            ->whereColumn('classroom_user.classroom_id', 'assignments.classroom_id')
            ->where('users.role', 'student')
            ->whereNull('users.deleted_at');

        return Assignment::query()
            ->whereHas('classroom', fn (Builder $q) => $q->visibleTo($teacher))
            ->with(['exercise:id,title_en,title_vi,skill', 'classroom:id,name'])
            ->select('assignments.*')
            ->selectSub((clone $students)->selectRaw('count(*)'), 'students_total')
            ->selectSub(
                (clone $students)
                    ->join('exercise_attempts', 'exercise_attempts.user_id', '=', 'users.id')
                    ->whereColumn('exercise_attempts.skill_exercise_id', 'assignments.skill_exercise_id')
                    ->selectRaw('count(distinct users.id)'),
                'students_done',
            )
            ->latest('assignments.created_at')
            ->latest('assignments.id')
            ->paginate(20);
    }

    private function forStudent(User $student)
    {
        $mine = fn () => DB::table('exercise_attempts')
            ->whereColumn('exercise_attempts.skill_exercise_id', 'assignments.skill_exercise_id')
            ->where('exercise_attempts.user_id', $student->id);

        return Assignment::query()
            ->whereIn('classroom_id', $student->classrooms()->select('classrooms.id'))
            ->with(['exercise:id,title_en,title_vi,skill', 'classroom:id,name'])
            ->select('assignments.*')
            ->selectSub($mine()->selectRaw('count(*)'), 'my_attempts')
            ->selectSub($mine()->selectRaw('max(score)'), 'my_best')
            ->selectSub($mine()->selectRaw('max(max_score)'), 'my_max')
            // Still to do first, nearest due date first; undated ones after dated ones.
            ->orderByRaw('case when assignments.due_at is null then 1 else 0 end')
            ->orderBy('assignments.due_at')
            ->latest('assignments.id')
            ->paginate(20);
    }
}
