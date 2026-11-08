<?php

namespace Tests\Feature\Skills;

use App\Enums\ExerciseSource;
use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Livewire\Curriculum\Show as UnitPage;
use App\Livewire\Skills\CreateExercise;
use App\Livewire\Skills\EditExercise;
use App\Livewire\Skills\ExercisePage;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\CurriculumUnit;
use App\Models\SkillExercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class TeacherExerciseTest extends TestCase
{
    use RefreshDatabase;

    private function ownedExercise(User $teacher, array $attributes = []): SkillExercise
    {
        $exercise = SkillExercise::factory()->create([
            'curriculum_unit_id' => null,
            'owner_id' => $teacher->id,
            'source' => ExerciseSource::Manual,
            'grade' => 7,
            'skill' => SkillType::Language,
            'passage' => null,
            'title_vi' => 'Kiểm tra 15 phút của cô Hoa',
            'title_en' => 'Ms Hoa 15-minute test',
            ...$attributes,
        ]);
        $exercise->questions()->create(['type' => 'gap_fill', 'prompt' => 'I ___ a student.', 'answer' => 'am', 'sort_order' => 1]);

        return $exercise;
    }

    public function test_a_teacher_creates_an_empty_exercise_they_own_and_lands_in_the_editor(): void
    {
        $teacher = User::factory()->teacher()->create();
        $unit = CurriculumUnit::factory()->create(['grade' => 8]);

        Livewire::actingAs($teacher)
            ->test(CreateExercise::class, ['unitId' => $unit->id])
            ->assertSet('grade', 8)
            ->set('method', 'manual')
            ->set('skill', 'language')
            ->call('createBlank')
            ->assertRedirect();

        $exercise = SkillExercise::sole();
        $this->assertSame($teacher->id, $exercise->owner_id);
        $this->assertSame(ExerciseSource::Manual, $exercise->source);
        $this->assertSame(TopicStatus::Draft, $exercise->status);
        $this->assertSame($unit->id, $exercise->curriculum_unit_id);
    }

    public function test_an_exercise_without_a_unit_keeps_the_chosen_grade(): void
    {
        $teacher = User::factory()->teacher()->create();

        Livewire::actingAs($teacher)
            ->test(CreateExercise::class)
            ->set('grade', 9)
            ->set('method', 'manual')
            ->call('createBlank');

        $exercise = SkillExercise::sole();
        $this->assertNull($exercise->curriculum_unit_id);
        $this->assertSame(9, $exercise->gradeLevel());
    }

    public function test_a_unit_of_another_grade_is_refused(): void
    {
        $unit = CurriculumUnit::factory()->create(['grade' => 6]);

        Livewire::actingAs(User::factory()->teacher()->create())
            ->test(CreateExercise::class)
            ->set('grade', 9)
            ->set('unitId', $unit->id)
            ->call('createBlank')
            ->assertHasErrors('unitId');

        $this->assertDatabaseCount('skill_exercises', 0);
    }

    public function test_students_cannot_open_the_create_page(): void
    {
        $this->actingAs(User::factory()->student()->create())
            ->get(route('exercises.create'))
            ->assertForbidden();
    }

    public function test_a_teachers_own_exercise_is_hidden_from_other_teachers_and_unassigned_students(): void
    {
        $owner = User::factory()->teacher()->create();
        $exercise = $this->ownedExercise($owner, ['status' => TopicStatus::Published]);

        $this->actingAs($owner)->get(route('exercises.show', $exercise))->assertOk()->assertSee('Kiểm tra 15 phút của cô Hoa');
        $this->actingAs(User::factory()->teacher()->create())->get(route('exercises.show', $exercise))->assertNotFound();
        $this->actingAs(User::factory()->student()->create())->get(route('exercises.show', $exercise))->assertNotFound();
    }

    public function test_an_owned_exercise_on_a_unit_does_not_appear_in_the_units_open_practice(): void
    {
        $owner = User::factory()->teacher()->create();
        $unit = CurriculumUnit::factory()->create(['grade' => 7]);
        $this->ownedExercise($owner, ['curriculum_unit_id' => $unit->id, 'status' => TopicStatus::Published]);

        $student = User::factory()->student()->create();
        Classroom::factory()->create(['grade' => 7])->students()->attach($student);

        Livewire::actingAs($student)->test(UnitPage::class, ['unit' => $unit])->assertDontSee('Kiểm tra 15 phút của cô Hoa');
        Livewire::actingAs($owner)->test(UnitPage::class, ['unit' => $unit])->assertSee('Kiểm tra 15 phút của cô Hoa');
    }

    public function test_only_the_owner_edits_their_exercise_while_open_practice_stays_shared(): void
    {
        $owner = User::factory()->teacher()->create();
        $other = User::factory()->teacher()->create();

        $this->actingAs($other)->get(route('exercises.edit', $this->ownedExercise($owner)))->assertForbidden();
        $this->actingAs($other)->get(route('exercises.edit', SkillExercise::factory()->create()))->assertOk();
    }

    public function test_an_assigned_student_opens_and_hands_in_an_exercise_without_a_unit(): void
    {
        $teacher = User::factory()->teacher()->create();
        $exercise = $this->ownedExercise($teacher, ['status' => TopicStatus::Published]);
        $classroom = Classroom::factory()->for($teacher, 'teacher')->create();
        $student = User::factory()->student()->create();
        $classroom->students()->attach($student);
        Assignment::factory()->create(['skill_exercise_id' => $exercise->id, 'classroom_id' => $classroom->id, 'assigned_by' => $teacher->id]);

        $this->actingAs($student)
            ->get(route('exercises.show', $exercise))
            ->assertOk()
            ->assertSee(route('assignments.index'), false);

        Livewire::actingAs($student)
            ->test(ExercisePage::class, ['exercise' => $exercise])
            ->set('answers.'.$exercise->questions()->first()->id, 'am')
            ->call('submit')
            ->assertSee('1/1');
    }

    public function test_language_practice_is_never_drafted_by_the_ai_from_the_unit_page(): void
    {
        Http::fake();
        $unit = CurriculumUnit::factory()->create(['focus_approved' => true]);

        Livewire::actingAs(User::factory()->teacher()->create())
            ->test(UnitPage::class, ['unit' => $unit])
            ->call('generateExercise', 'language')
            ->assertSee(__('skills.language_is_written'));

        Http::assertNothingSent();
    }

    public function test_the_editor_shows_the_teachers_language_exercise_with_its_grade(): void
    {
        $teacher = User::factory()->teacher()->create();

        Livewire::actingAs($teacher)
            ->test(EditExercise::class, ['exercise' => $this->ownedExercise($teacher)])
            ->assertSee(__('skills.no_unit_label'))
            ->assertSee(__('skills.source.manual'));
    }
}
