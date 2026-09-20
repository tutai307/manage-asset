<?php

namespace Tests\Feature\Skills;

use App\Livewire\Skills\EditExercise;
use App\Models\CurriculumUnit;
use App\Models\ExerciseQuestion;
use App\Models\SkillExercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditExerciseTest extends TestCase
{
    use RefreshDatabase;

    private function exercise(): SkillExercise
    {
        $unit = CurriculumUnit::factory()->create(['focus_approved' => true]);

        return SkillExercise::factory()->for($unit, 'unit')->create();
    }

    public function test_teacher_edits_the_passage_and_a_question(): void
    {
        $teacher = User::factory()->teacher()->create();
        $exercise = $this->exercise();
        $question = ExerciseQuestion::factory()->for($exercise, 'exercise')->create();

        Livewire::actingAs($teacher)
            ->test(EditExercise::class, ['exercise' => $exercise])
            ->assertSet('titleVi', 'Ở chợ')
            ->set('titleVi', 'Đi chợ cùng mẹ')
            ->set('passage', 'Lan goes to the market with her mother on Sunday morning.')
            ->set('questions.0.prompt', 'Who goes with Lan?')
            ->set('questions.0.options', "Her mother\nHer brother\nHer teacher")
            ->set('questions.0.answer', 'Her mother')
            ->call('save')
            ->assertHasNoErrors()
            ->assertRedirect(route('exercises.show', $exercise));

        $exercise->refresh();
        $this->assertSame('Đi chợ cùng mẹ', $exercise->title_vi);
        $this->assertStringContainsString('Sunday morning', $exercise->passage);

        $question->refresh();
        $this->assertSame('Who goes with Lan?', $question->prompt);
        $this->assertSame(['Her mother', 'Her brother', 'Her teacher'], $question->options);
        $this->assertSame('Her mother', $question->answer);
    }

    public function test_an_answer_outside_the_options_is_refused(): void
    {
        $teacher = User::factory()->teacher()->create();
        $exercise = $this->exercise();
        ExerciseQuestion::factory()->for($exercise, 'exercise')->create();

        Livewire::actingAs($teacher)
            ->test(EditExercise::class, ['exercise' => $exercise])
            ->set('questions.0.options', "On Sunday\nOn Monday")
            ->set('questions.0.answer', 'On Friday')
            ->call('save')
            ->assertHasErrors(['questions.0.answer'])
            ->assertSee('Đáp án phải trùng với một trong các phương án');
    }

    public function test_teacher_adds_and_removes_questions(): void
    {
        $teacher = User::factory()->teacher()->create();
        $exercise = $this->exercise();
        $keep = ExerciseQuestion::factory()->for($exercise, 'exercise')->create();
        $drop = ExerciseQuestion::factory()->for($exercise, 'exercise')->gapFill()->create(['sort_order' => 2]);

        Livewire::actingAs($teacher)
            ->test(EditExercise::class, ['exercise' => $exercise])
            ->call('removeQuestion', 1)
            ->call('addQuestion')
            ->set('questions.1.type', 'gap_fill')
            ->set('questions.1.prompt', 'Lan buys some ___.')
            ->set('questions.1.answer', 'fruit')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame(2, $exercise->questions()->count());
        $this->assertDatabaseMissing('exercise_questions', ['id' => $drop->id]);
        $this->assertDatabaseHas('exercise_questions', ['id' => $keep->id, 'sort_order' => 1]);
        $this->assertDatabaseHas('exercise_questions', ['prompt' => 'Lan buys some ___.', 'answer' => 'fruit', 'sort_order' => 2]);
    }

    public function test_a_reading_exercise_cannot_be_saved_without_a_passage(): void
    {
        $teacher = User::factory()->teacher()->create();
        $exercise = $this->exercise();
        ExerciseQuestion::factory()->for($exercise, 'exercise')->create();

        Livewire::actingAs($teacher)
            ->test(EditExercise::class, ['exercise' => $exercise])
            ->set('passage', '')
            ->call('save')
            ->assertHasErrors(['passage']);
    }

    public function test_a_writing_task_keeps_its_prompt_and_length(): void
    {
        $teacher = User::factory()->teacher()->create();
        $unit = CurriculumUnit::factory()->create(['focus_approved' => true]);
        $exercise = SkillExercise::factory()->writing()->for($unit, 'unit')->create();

        Livewire::actingAs($teacher)
            ->test(EditExercise::class, ['exercise' => $exercise])
            ->set('promptVi', 'Viết 5 câu về lần đi mua sắm của em.')
            ->set('minWords', 60)
            ->call('save')
            ->assertHasNoErrors();

        $exercise->refresh();
        $this->assertSame('Viết 5 câu về lần đi mua sắm của em.', $exercise->prompt_vi);
        $this->assertSame(60, $exercise->min_words);
    }

    public function test_a_student_cannot_open_the_editor(): void
    {
        $student = User::factory()->student()->create();
        $exercise = $this->exercise();

        $this->actingAs($student)->get(route('exercises.edit', $exercise))->assertForbidden();
    }
}
