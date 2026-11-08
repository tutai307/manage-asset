<?php

namespace Tests\Feature\Curriculum;

use App\Enums\ExerciseSource;
use App\Enums\MessageRole;
use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Livewire\Curriculum\Show as UnitPage;
use App\Models\Classroom;
use App\Models\Conversation;
use App\Models\CurriculumUnit;
use App\Models\ExerciseAttempt;
use App\Models\RoleplayScenario;
use App\Models\SkillExercise;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class UnitPageActionsTest extends TestCase
{
    use RefreshDatabase;

    private CurriculumUnit $unit;

    private User $teacher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unit = CurriculumUnit::factory()->create(['grade' => 7]);
        $this->teacher = User::factory()->teacher()->create();
    }

    private function ownedExercise(array $attributes = []): SkillExercise
    {
        return SkillExercise::factory()->create([
            'curriculum_unit_id' => $this->unit->id, 'owner_id' => $this->teacher->id,
            'source' => ExerciseSource::Generated, 'status' => TopicStatus::Draft, 'title_vi' => 'Bài đọc AI tạo',
            ...$attributes,
        ]);
    }

    public function test_the_teacher_deletes_their_exercise_with_its_original_files(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('exercise-sources/abc.jpg', 'x');
        $exercise = $this->ownedExercise(['source' => ExerciseSource::Upload, 'source_files' => ['files' => ['exercise-sources/abc.jpg']]]);

        Livewire::actingAs($this->teacher)
            ->test(UnitPage::class, ['unit' => $this->unit])
            ->call('deleteExercise', $exercise->id)
            ->assertDispatched('notify');

        $this->assertModelMissing($exercise);
        Storage::disk('local')->assertMissing('exercise-sources/abc.jpg');
    }

    public function test_an_exercise_students_have_done_cannot_be_deleted(): void
    {
        $exercise = $this->ownedExercise();
        ExerciseAttempt::create(['user_id' => User::factory()->student()->create()->id, 'skill_exercise_id' => $exercise->id, 'score' => 1, 'max_score' => 1, 'answers' => []]);

        Livewire::actingAs($this->teacher)
            ->test(UnitPage::class, ['unit' => $this->unit])
            ->call('deleteExercise', $exercise->id)
            ->assertSee(__('skills.delete_in_use'));

        $this->assertModelExists($exercise);
    }

    public function test_another_teacher_cannot_delete_it_and_shipped_practice_is_kept(): void
    {
        $exercise = $this->ownedExercise();
        $shipped = SkillExercise::factory()->create(['curriculum_unit_id' => $this->unit->id]);
        $other = User::factory()->teacher()->create();

        Livewire::actingAs($other)->test(UnitPage::class, ['unit' => $this->unit])->call('deleteExercise', $exercise->id)->assertForbidden();
        Livewire::actingAs($other)->test(UnitPage::class, ['unit' => $this->unit])->call('deleteExercise', $shipped->id)->assertForbidden();

        $this->assertModelExists($exercise);
        $this->assertModelExists($shipped);
    }

    public function test_an_unreviewed_draft_that_belongs_to_nobody_can_be_deleted(): void
    {
        $draft = SkillExercise::factory()->draft()->create(['curriculum_unit_id' => $this->unit->id]);

        Livewire::actingAs($this->teacher)->test(UnitPage::class, ['unit' => $this->unit])->call('deleteExercise', $draft->id);

        $this->assertModelMissing($draft);
    }

    public function test_an_ai_exercise_is_not_shown_to_students_until_it_is_assigned(): void
    {
        $this->ownedExercise(['skill' => SkillType::Reading]);
        $student = User::factory()->student()->create();
        Classroom::factory()->create(['grade' => 7])->students()->attach($student);

        Livewire::actingAs($student)->test(UnitPage::class, ['unit' => $this->unit])->assertDontSee('Bài đọc AI tạo');
        Livewire::actingAs($this->teacher)->test(UnitPage::class, ['unit' => $this->unit])
            ->assertSee('Bài đọc AI tạo')
            ->assertSee(__('skills.not_assigned'))
            ->assertDontSee(__('topics.status.draft'));
    }

    public function test_a_student_calls_a_companion_from_the_units_speaking_card(): void
    {
        $topic = Topic::factory()->create(['curriculum_unit_id' => $this->unit->id, 'status' => TopicStatus::Published]);
        $scenario = RoleplayScenario::factory()->for($topic)->create(['opening_line' => 'Hi! Welcome to our club.']);
        $student = User::factory()->student()->create();

        Livewire::actingAs($student)
            ->test(UnitPage::class, ['unit' => $this->unit])
            ->assertSee(__('curriculum.call'))
            ->call('startRoleplay', $scenario->id)
            ->assertRedirect();

        $conversation = Conversation::sole();
        $this->assertSame($student->id, $conversation->user_id);
        $this->assertSame('Hi! Welcome to our club.', $conversation->messages()->where('role', MessageRole::Assistant)->value('content'));
    }

    public function test_a_speaking_lesson_not_open_to_students_cannot_be_called(): void
    {
        $topic = Topic::factory()->create(['curriculum_unit_id' => $this->unit->id, 'status' => TopicStatus::Draft]);
        $scenario = RoleplayScenario::factory()->for($topic)->create();

        Livewire::actingAs(User::factory()->student()->create())
            ->test(UnitPage::class, ['unit' => $this->unit])
            ->call('startRoleplay', $scenario->id)
            ->assertStatus(404);

        $this->assertDatabaseCount('conversations', 0);
    }

    public function test_a_speaking_lesson_is_deleted_unless_students_practised_it(): void
    {
        $unused = Topic::factory()->create(['curriculum_unit_id' => $this->unit->id]);
        $used = Topic::factory()->create(['curriculum_unit_id' => $this->unit->id]);
        Conversation::factory()->for(RoleplayScenario::factory()->for($used), 'scenario')->create();

        $page = Livewire::actingAs($this->teacher)->test(UnitPage::class, ['unit' => $this->unit]);
        $page->call('deleteTopic', $unused->id)->assertDispatched('notify');
        $page->call('deleteTopic', $used->id)->assertSee(__('curriculum.delete_in_use'));

        $this->assertModelMissing($unused);
        $this->assertModelExists($used);
    }
}
