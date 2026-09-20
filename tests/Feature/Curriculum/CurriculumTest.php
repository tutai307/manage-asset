<?php

namespace Tests\Feature\Curriculum;

use App\Enums\TopicStatus;
use App\Livewire\Curriculum\Index;
use App\Livewire\Curriculum\Show;
use App\Models\Classroom;
use App\Models\CurriculumUnit;
use App\Models\Topic;
use App\Models\User;
use Database\Seeders\CurriculumUnitSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CurriculumTest extends TestCase
{
    use RefreshDatabase;

    private function studentInGrade(int $grade): User
    {
        $student = User::factory()->student()->create();
        Classroom::factory()->create(['name' => $grade.'A', 'grade' => $grade])->students()->attach($student);

        return $student;
    }

    public function test_all_four_grades_are_seeded_with_twelve_units_each(): void
    {
        $this->seed(CurriculumUnitSeeder::class);

        $this->assertSame(48, CurriculumUnit::count());

        foreach (CurriculumUnit::GRADES as $grade) {
            $this->assertSame(12, CurriculumUnit::where('grade', $grade)->count(), "grade {$grade}");
            $this->assertSame(6, CurriculumUnit::where('grade', $grade)->where('term', 1)->count(), "grade {$grade} term 1");
        }

        $this->assertDatabaseHas('curriculum_units', ['grade' => 8, 'number' => 8, 'title_en' => 'Shopping']);
        $this->assertDatabaseHas('curriculum_units', ['grade' => 9, 'number' => 9, 'title_en' => 'World Englishes']);
    }

    public function test_the_seeder_is_idempotent(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $this->seed(CurriculumUnitSeeder::class);

        $this->assertSame(48, CurriculumUnit::count());
    }

    public function test_student_sees_the_units_of_their_own_grade_only(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $student = $this->studentInGrade(7);

        Livewire::actingAs($student)
            ->test(Index::class)
            ->assertSet('grade', '7')
            ->assertSee('Hobbies')
            ->assertDontSee('Leisure Time');
    }

    public function test_student_cannot_switch_grade(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $student = $this->studentInGrade(7);

        Livewire::actingAs($student)
            ->test(Index::class)
            ->call('setGrade', 9)
            ->assertSet('grade', '7')
            ->assertDontSee('Career Choices');
    }

    public function test_teacher_can_switch_between_grades(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $teacher = User::factory()->teacher()->create();

        Livewire::actingAs($teacher)
            ->test(Index::class)
            ->call('setGrade', 9)
            ->assertSet('grade', '9')
            ->assertSee('Career Choices');
    }

    public function test_students_do_not_see_draft_lessons_on_a_unit(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $unit = CurriculumUnit::where('grade', 8)->where('number', 8)->firstOrFail();
        Topic::factory()->for($unit, 'unit')->create(['title_vi' => 'Bài đã duyệt']);
        Topic::factory()->draft()->for($unit, 'unit')->create(['title_vi' => 'Bài nháp']);

        Livewire::actingAs($this->studentInGrade(8))
            ->test(Show::class, ['unit' => $unit])
            ->assertSee('Bài đã duyệt')
            ->assertDontSee('Bài nháp');
    }

    public function test_teacher_publishes_and_unpublishes_a_lesson(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $teacher = User::factory()->teacher()->create();
        $unit = CurriculumUnit::where('grade', 8)->where('number', 8)->firstOrFail();
        $topic = Topic::factory()->draft()->for($unit, 'unit')->create();

        $component = Livewire::actingAs($teacher)->test(Show::class, ['unit' => $unit]);

        $component->call('publish', $topic->id)->assertDispatched('notify');
        $this->assertSame(TopicStatus::Published, $topic->fresh()->status);

        $component->call('unpublish', $topic->id)->assertDispatched('notify');
        $this->assertSame(TopicStatus::Draft, $topic->fresh()->status);
    }

    public function test_student_cannot_publish_a_lesson(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $unit = CurriculumUnit::where('grade', 8)->where('number', 8)->firstOrFail();
        $topic = Topic::factory()->draft()->for($unit, 'unit')->create();

        Livewire::actingAs($this->studentInGrade(8))
            ->test(Show::class, ['unit' => $unit])
            ->call('publish', $topic->id)
            ->assertForbidden();

        $this->assertSame(TopicStatus::Draft, $topic->fresh()->status);
    }

    public function test_guest_cannot_open_the_syllabus(): void
    {
        $this->get(route('curriculum.index'))->assertRedirect(route('login'));
    }
}
