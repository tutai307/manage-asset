<?php

namespace Tests\Feature\Skills;

use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Livewire\Curriculum\Show as UnitPage;
use App\Livewire\Skills\ExercisePage;
use App\Models\Classroom;
use App\Models\CurriculumUnit;
use App\Models\ExerciseQuestion;
use App\Models\SkillExercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class SkillExerciseTest extends TestCase
{
    use RefreshDatabase;

    private function unitWithFocus(): CurriculumUnit
    {
        $unit = CurriculumUnit::factory()->create([
            'grade' => 8, 'number' => 8, 'title_en' => 'Shopping', 'title_vi' => 'Mua sắm',
            'grammar_en' => 'Comparative adjectives', 'focus_approved' => true,
        ]);

        $unit->vocabulary()->createMany([
            ['word' => 'discount', 'part_of_speech' => 'n', 'meaning_vi' => 'giảm giá', 'sort_order' => 1],
            ['word' => 'try on', 'part_of_speech' => 'v', 'meaning_vi' => 'mặc thử', 'sort_order' => 2],
        ]);

        return $unit;
    }

    private function studentInGrade(int $grade = 8): User
    {
        $student = User::factory()->student()->create();
        Classroom::factory()->create(['name' => $grade.'A', 'grade' => $grade])->students()->attach($student);

        return $student;
    }

    private function fakeReadingExercise(): void
    {
        $payload = json_encode([
            'title_en' => 'A shopping trip', 'title_vi' => 'Một buổi đi mua sắm',
            'instructions_en' => 'Read and answer.', 'instructions_vi' => 'Đọc rồi trả lời.',
            'passage' => 'Mai goes to the market. The shirt has a discount today. She wants to try on a blue one.',
            'questions' => [
                ['type' => 'multiple_choice', 'prompt' => 'Where does Mai go?', 'options' => ['To the market', 'To school', 'To the park'], 'answer' => 'To the market', 'explanation_vi' => 'Câu đầu tiên nói vậy.'],
                ['type' => 'true_false', 'prompt' => 'The shirt has a discount.', 'options' => ['True', 'False'], 'answer' => 'True', 'explanation_vi' => 'Đoạn văn nói có giảm giá.'],
                ['type' => 'gap_fill', 'prompt' => 'Mai wants to try on a ___ shirt.', 'options' => null, 'answer' => 'blue', 'explanation_vi' => 'Màu xanh.'],
            ],
        ]);

        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => $payload]]]])]);
    }

    public function test_teacher_generates_a_reading_exercise_limited_to_the_unit_vocabulary(): void
    {
        $teacher = User::factory()->teacher()->create();
        $unit = $this->unitWithFocus();
        $this->fakeReadingExercise();

        Livewire::actingAs($teacher)
            ->test(UnitPage::class, ['unit' => $unit])
            ->call('generateExercise', SkillType::Reading->value)
            ->assertDispatched('notify');

        $exercise = SkillExercise::firstOrFail();
        $this->assertSame(SkillType::Reading, $exercise->skill);
        $this->assertSame(TopicStatus::Draft, $exercise->status, 'generated practice must be reviewed first');
        $this->assertSame(3, $exercise->questions()->count());

        Http::assertSent(function (Request $request) {
            $brief = $request->data()['messages'][1]['content'];

            return str_contains($brief, 'Grade 8, Unit 8: "Shopping"')
                && str_contains($brief, 'discount (n) = giảm giá')
                && str_contains($brief, 'Comparative adjectives');
        });
    }

    public function test_generation_is_refused_until_the_teacher_has_entered_the_unit_vocabulary(): void
    {
        Http::fake();
        $teacher = User::factory()->teacher()->create();
        $unit = CurriculumUnit::factory()->create(['focus_approved' => false]);

        Livewire::actingAs($teacher)
            ->test(UnitPage::class, ['unit' => $unit])
            ->call('generateExercise', SkillType::Reading->value)
            ->assertSee('Cần nhập từ vựng của unit trước');

        Http::assertNothingSent();
        $this->assertDatabaseCount('skill_exercises', 0);
    }

    public function test_a_question_whose_answer_is_missing_from_its_options_is_dropped(): void
    {
        $teacher = User::factory()->teacher()->create();
        $unit = $this->unitWithFocus();
        $payload = json_encode([
            'title_en' => 'A shopping trip', 'title_vi' => 'Đi mua sắm',
            'instructions_en' => 'Read.', 'instructions_vi' => 'Đọc.',
            'passage' => 'Mai goes to the market and buys a shirt with a discount.',
            'questions' => [
                ['type' => 'multiple_choice', 'prompt' => 'Ok?', 'options' => ['A', 'B'], 'answer' => 'A', 'explanation_vi' => null],
                ['type' => 'multiple_choice', 'prompt' => 'Broken?', 'options' => ['A', 'B'], 'answer' => 'C', 'explanation_vi' => null],
                ['type' => 'gap_fill', 'prompt' => 'Mai buys a ___.', 'options' => null, 'answer' => 'shirt', 'explanation_vi' => null],
                ['type' => 'gap_fill', 'prompt' => 'It has a ___.', 'options' => null, 'answer' => 'discount', 'explanation_vi' => null],
            ],
        ]);
        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => $payload]]]])]);

        Livewire::actingAs($teacher)->test(UnitPage::class, ['unit' => $unit])->call('generateExercise', 'reading');

        $this->assertSame(3, ExerciseQuestion::count());
        $this->assertDatabaseMissing('exercise_questions', ['prompt' => 'Broken?']);
    }

    public function test_unparseable_answer_stores_nothing(): void
    {
        $teacher = User::factory()->teacher()->create();
        $unit = $this->unitWithFocus();
        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => 'Here you go!']]]])]);

        Livewire::actingAs($teacher)
            ->test(UnitPage::class, ['unit' => $unit])
            ->call('generateExercise', 'reading')
            ->assertSee('Chưa tạo được bài luyện');

        $this->assertDatabaseCount('skill_exercises', 0);
    }

    public function test_student_cannot_generate_an_exercise(): void
    {
        Http::fake();
        $unit = $this->unitWithFocus();

        Livewire::actingAs($this->studentInGrade())
            ->test(UnitPage::class, ['unit' => $unit])
            ->call('generateExercise', 'reading')
            ->assertForbidden();

        Http::assertNothingSent();
    }

    public function test_student_answers_a_reading_exercise_and_is_marked(): void
    {
        $unit = $this->unitWithFocus();
        $exercise = SkillExercise::factory()->for($unit, 'unit')->create();
        $q1 = ExerciseQuestion::factory()->for($exercise, 'exercise')->create();
        $q2 = ExerciseQuestion::factory()->for($exercise, 'exercise')->gapFill()->create(['sort_order' => 2]);
        $student = $this->studentInGrade();

        Livewire::actingAs($student)
            ->test(ExercisePage::class, ['exercise' => $exercise])
            ->set("answers.{$q1->id}", 'On Sunday')
            ->set("answers.{$q2->id}", '  Shirt. ')     // marking ignores case, spacing and punctuation
            ->call('submit')
            ->assertSee('2/2');

        $this->assertDatabaseHas('exercise_attempts', [
            'user_id' => $student->id,
            'skill_exercise_id' => $exercise->id,
            'score' => 2,
            'max_score' => 2,
        ]);
    }

    public function test_a_wrong_answer_shows_the_correct_one(): void
    {
        $unit = $this->unitWithFocus();
        $exercise = SkillExercise::factory()->for($unit, 'unit')->create();
        $question = ExerciseQuestion::factory()->for($exercise, 'exercise')->create();

        Livewire::actingAs($this->studentInGrade())
            ->test(ExercisePage::class, ['exercise' => $exercise])
            ->set("answers.{$question->id}", 'On Monday')
            ->call('submit')
            ->assertSee('0/1')
            ->assertSee('On Sunday')
            ->assertSee('Đoạn văn nói Lan đi chợ vào Chủ nhật.');
    }

    public function test_handing_in_with_a_blank_answer_is_refused(): void
    {
        $unit = $this->unitWithFocus();
        $exercise = SkillExercise::factory()->for($unit, 'unit')->create();
        ExerciseQuestion::factory()->for($exercise, 'exercise')->create();

        Livewire::actingAs($this->studentInGrade())
            ->test(ExercisePage::class, ['exercise' => $exercise])
            ->call('submit')
            ->assertSee('Em hãy trả lời hết các câu');

        $this->assertDatabaseCount('exercise_attempts', 0);
    }

    public function test_every_attempt_is_kept(): void
    {
        $unit = $this->unitWithFocus();
        $exercise = SkillExercise::factory()->for($unit, 'unit')->create();
        $question = ExerciseQuestion::factory()->for($exercise, 'exercise')->create();

        Livewire::actingAs($this->studentInGrade())
            ->test(ExercisePage::class, ['exercise' => $exercise])
            ->set("answers.{$question->id}", 'On Monday')
            ->call('submit')
            ->call('tryAgain')
            ->set("answers.{$question->id}", 'On Sunday')
            ->call('submit')
            ->assertSee('1/1');

        $this->assertDatabaseCount('exercise_attempts', 2);
    }

    public function test_students_cannot_open_a_draft_exercise(): void
    {
        $exercise = SkillExercise::factory()->draft()->for($this->unitWithFocus(), 'unit')->create();

        $this->actingAs($this->studentInGrade())
            ->get(route('exercises.show', $exercise))
            ->assertNotFound();
    }

    public function test_teacher_previews_but_cannot_hand_in(): void
    {
        $teacher = User::factory()->teacher()->create();
        $exercise = SkillExercise::factory()->for($this->unitWithFocus(), 'unit')->create();
        $question = ExerciseQuestion::factory()->for($exercise, 'exercise')->create();

        Livewire::actingAs($teacher)
            ->test(ExercisePage::class, ['exercise' => $exercise])
            ->assertSee('Thầy cô đang xem thử')
            ->set("answers.{$question->id}", 'On Sunday')
            ->call('submit')
            ->assertForbidden();

        $this->assertDatabaseCount('exercise_attempts', 0);
    }

    public function test_writing_is_marked_by_the_ai_and_stores_the_feedback(): void
    {
        $unit = $this->unitWithFocus();
        $exercise = SkillExercise::factory()->writing()->for($unit, 'unit')->create();
        $student = $this->studentInGrade();

        $payload = json_encode([
            'score' => 7,
            'feedback_vi' => 'Bài viết rõ ý. Chú ý thì quá khứ của động từ "go".',
            'feedback_en' => 'Clear writing. Watch the past tense of "go".',
        ]);
        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => $payload]]]])]);

        Livewire::actingAs($student)
            ->test(ExercisePage::class, ['exercise' => $exercise])
            ->set('written', 'Last Sunday I go to the market with my mother. We buy a shirt with a discount.')
            ->call('submit')
            ->assertSee('7/10')
            ->assertSee('Chú ý thì quá khứ');

        $this->assertDatabaseHas('exercise_attempts', ['user_id' => $student->id, 'score' => 7, 'max_score' => 10]);
    }

    public function test_writing_shorter_than_the_minimum_is_refused_before_calling_the_ai(): void
    {
        Http::fake();
        $exercise = SkillExercise::factory()->writing()->for($this->unitWithFocus(), 'unit')->create();

        Livewire::actingAs($this->studentInGrade())
            ->test(ExercisePage::class, ['exercise' => $exercise])
            ->set('written', 'Too short')
            ->call('submit')
            ->assertHasErrors(['written']);

        Http::assertNothingSent();
        $this->assertDatabaseCount('exercise_attempts', 0);
    }

    public function test_ai_failure_while_marking_writing_stores_nothing(): void
    {
        $exercise = SkillExercise::factory()->writing()->for($this->unitWithFocus(), 'unit')->create();
        Http::fake(['openrouter.ai/*' => Http::response(['error' => 'overloaded'], 503)]);

        Livewire::actingAs($this->studentInGrade())
            ->test(ExercisePage::class, ['exercise' => $exercise])
            ->set('written', 'Last Sunday I went to the market with my mother and we bought a shirt.')
            ->call('submit')
            ->assertSee('Chưa chấm được bài');

        $this->assertDatabaseCount('exercise_attempts', 0);
    }

    public function test_the_listening_script_is_never_sent_without_the_play_control(): void
    {
        $exercise = SkillExercise::factory()->listening()->for($this->unitWithFocus(), 'unit')->create();

        $this->actingAs($this->studentInGrade())
            ->get(route('exercises.show', $exercise))
            ->assertOk()
            ->assertSee(__('skills.play'))
            ->assertSee(__('skills.show_script'));
    }
}
