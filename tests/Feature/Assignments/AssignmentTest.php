<?php

namespace Tests\Feature\Assignments;

use App\Enums\ExerciseSource;
use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Livewire\Assignments\AssignPanel;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\ExerciseAttempt;
use App\Models\SkillExercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\TestCase;

class AssignmentTest extends TestCase
{
    use RefreshDatabase;

    private User $teacher;

    private Classroom $classroom;

    private User $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->teacher = User::factory()->teacher()->create();
        $this->classroom = Classroom::factory()->for($this->teacher, 'teacher')->create(['name' => '7A', 'grade' => 7]);
        $this->student = User::factory()->student()->create(['name' => 'Lê Minh Châu']);
        $this->classroom->students()->attach($this->student);
    }

    private function exercise(array $attributes = []): SkillExercise
    {
        $exercise = SkillExercise::factory()->create([
            'curriculum_unit_id' => null,
            'owner_id' => $this->teacher->id,
            'source' => ExerciseSource::Upload,
            'grade' => 7,
            'skill' => SkillType::Language,
            'passage' => null,
            'status' => TopicStatus::Draft,
            'title_vi' => 'Đề kiểm tra tuần 5',
            'title_en' => 'Week 5 quiz',
            ...$attributes,
        ]);
        $exercise->questions()->create(['type' => 'gap_fill', 'prompt' => 'She ___ to school.', 'answer' => 'goes', 'sort_order' => 1]);

        return $exercise;
    }

    public function test_a_teacher_assigns_an_exercise_to_their_class_with_a_due_date(): void
    {
        $exercise = $this->exercise();

        Livewire::actingAs($this->teacher)
            ->test(AssignPanel::class, ['exerciseId' => $exercise->id])
            ->set('classroomIds', [$this->classroom->id])
            ->set('dueAt', now('Asia/Ho_Chi_Minh')->addDays(2)->setTime(21, 0)->format('Y-m-d\TH:i'))
            ->call('assign')
            ->assertHasNoErrors()
            ->assertDispatched('notify');

        $assignment = Assignment::sole();
        $this->assertSame($this->classroom->id, $assignment->classroom_id);
        // 21:00 in Vietnam is stored as 14:00 UTC.
        $this->assertSame('14:00', $assignment->due_at->utc()->format('H:i'));
        // Assigning shows it to that class only; it does not open it to the whole grade.
        $this->assertSame(TopicStatus::Draft, $exercise->fresh()->status);
    }

    public function test_the_student_sees_the_assignment_in_their_list_and_on_the_dashboard(): void
    {
        $exercise = $this->exercise(['status' => TopicStatus::Published]);
        Assignment::factory()->create(['skill_exercise_id' => $exercise->id, 'classroom_id' => $this->classroom->id, 'assigned_by' => $this->teacher->id]);

        $this->actingAs($this->student)->get(route('assignments.index'))->assertOk()->assertSee('Đề kiểm tra tuần 5')->assertSee(__('assignments.not_done'));
        $this->actingAs($this->student)->get(route('home'))->assertOk()->assertSee('Đề kiểm tra tuần 5');
        $this->actingAs($this->student)->get(route('exercises.show', $exercise))->assertOk();
    }

    public function test_a_done_assignment_leaves_the_dashboard_and_shows_the_score(): void
    {
        $exercise = $this->exercise(['status' => TopicStatus::Published]);
        Assignment::factory()->create(['skill_exercise_id' => $exercise->id, 'classroom_id' => $this->classroom->id, 'assigned_by' => $this->teacher->id]);
        ExerciseAttempt::create(['user_id' => $this->student->id, 'skill_exercise_id' => $exercise->id, 'score' => 1, 'max_score' => 1, 'answers' => []]);

        $this->actingAs($this->student)->get(route('assignments.index'))->assertSee(__('assignments.done').' · 1/1');
        $this->actingAs($this->student)->get(route('home'))->assertDontSee('Đề kiểm tra tuần 5');
    }

    public function test_a_student_of_another_class_does_not_see_the_assignment(): void
    {
        $exercise = $this->exercise(['status' => TopicStatus::Published]);
        Assignment::factory()->create(['skill_exercise_id' => $exercise->id, 'classroom_id' => $this->classroom->id, 'assigned_by' => $this->teacher->id]);

        $outsider = User::factory()->student()->create();
        Classroom::factory()->create()->students()->attach($outsider);

        $this->actingAs($outsider)->get(route('assignments.index'))->assertDontSee('Đề kiểm tra tuần 5');
        $this->actingAs($outsider)->get(route('exercises.show', $exercise))->assertNotFound();
    }

    public function test_a_teacher_cannot_assign_to_another_teachers_class(): void
    {
        $exercise = $this->exercise();
        $otherClass = Classroom::factory()->create();

        Livewire::actingAs($this->teacher)
            ->test(AssignPanel::class, ['exerciseId' => $exercise->id])
            ->set('classroomIds', [$otherClass->id])
            ->call('assign');

        $this->assertDatabaseCount('assignments', 0);
    }

    public function test_questions_still_marked_for_checking_block_the_assignment(): void
    {
        $exercise = $this->exercise();
        $exercise->questions()->update(['needs_check' => true]);

        Livewire::actingAs($this->teacher)
            ->test(AssignPanel::class, ['exerciseId' => $exercise->id])
            ->set('classroomIds', [$this->classroom->id])
            ->call('assign')
            ->assertSee(__('assignments.needs_review'));

        $this->assertDatabaseCount('assignments', 0);
        $this->assertSame(TopicStatus::Draft, $exercise->fresh()->status);
    }

    public function test_a_due_date_in_the_past_is_refused(): void
    {
        Livewire::actingAs($this->teacher)
            ->test(AssignPanel::class, ['exerciseId' => $this->exercise()->id])
            ->set('classroomIds', [$this->classroom->id])
            ->set('dueAt', '2020-01-01T08:00')
            ->call('assign')
            ->assertHasErrors('dueAt');
    }

    public function test_the_results_show_who_has_done_it_and_who_was_late(): void
    {
        $exercise = $this->exercise(['status' => TopicStatus::Published]);
        $assignment = Assignment::factory()->create([
            'skill_exercise_id' => $exercise->id, 'classroom_id' => $this->classroom->id,
            'assigned_by' => $this->teacher->id, 'due_at' => Carbon::parse('2026-10-20 10:00'),
        ]);
        $lazy = User::factory()->student()->create(['name' => 'Phạm Gia Huy']);
        $this->classroom->students()->attach($lazy);

        $late = ExerciseAttempt::create(['user_id' => $this->student->id, 'skill_exercise_id' => $exercise->id, 'score' => 1, 'max_score' => 1, 'answers' => []]);
        $late->forceFill(['created_at' => Carbon::parse('2026-10-21 08:00')])->save();

        $this->actingAs($this->teacher)
            ->get(route('assignments.show', $assignment))
            ->assertOk()
            ->assertSee('Lê Minh Châu')
            ->assertSee('1/1')
            ->assertSee(__('assignments.late'))
            ->assertSee('Phạm Gia Huy')
            ->assertSee(__('assignments.not_done'));

        $this->actingAs($this->teacher)->get(route('assignments.index'))->assertSee(__('assignments.completed', ['done' => 1, 'total' => 2]));
    }

    public function test_another_teacher_and_students_cannot_see_the_results(): void
    {
        $assignment = Assignment::factory()->create(['skill_exercise_id' => $this->exercise()->id, 'classroom_id' => $this->classroom->id, 'assigned_by' => $this->teacher->id]);

        $this->actingAs(User::factory()->teacher()->create())->get(route('assignments.show', $assignment))->assertForbidden();
        $this->actingAs($this->student)->get(route('assignments.show', $assignment))->assertForbidden();
    }

    public function test_removing_an_assignment_keeps_the_students_attempts(): void
    {
        $exercise = $this->exercise(['status' => TopicStatus::Published]);
        $assignment = Assignment::factory()->create(['skill_exercise_id' => $exercise->id, 'classroom_id' => $this->classroom->id, 'assigned_by' => $this->teacher->id]);
        ExerciseAttempt::create(['user_id' => $this->student->id, 'skill_exercise_id' => $exercise->id, 'score' => 1, 'max_score' => 1, 'answers' => []]);

        Livewire::actingAs($this->teacher)
            ->test(AssignPanel::class, ['exerciseId' => $exercise->id])
            ->call('unassign', $assignment->id);

        $this->assertModelMissing($assignment);
        $this->assertDatabaseCount('exercise_attempts', 1);
    }

    public function test_open_unit_practice_can_be_assigned_too(): void
    {
        $practice = SkillExercise::factory()->create();
        $practice->questions()->create(['type' => 'true_false', 'prompt' => 'Lan goes on Sunday.', 'options' => ['True', 'False'], 'answer' => 'True', 'sort_order' => 1]);

        Livewire::actingAs($this->teacher)
            ->test(AssignPanel::class, ['exerciseId' => $practice->id])
            ->set('classroomIds', [$this->classroom->id])
            ->call('assign')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('assignments', ['skill_exercise_id' => $practice->id, 'classroom_id' => $this->classroom->id]);
    }
}
