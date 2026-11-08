<?php

namespace Tests\Feature\Skills;

use App\Actions\Skills\SubmitExerciseAttempt;
use App\Enums\QuestionType;
use App\Enums\SkillType;
use App\Livewire\Skills\EditExercise;
use App\Models\ExerciseQuestion;
use App\Models\SkillExercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Js;
use Livewire\Livewire;
use Tests\TestCase;

class QuestionTypesTest extends TestCase
{
    use RefreshDatabase;

    private function question(array $attributes): ExerciseQuestion
    {
        return ExerciseQuestion::factory()->for(SkillExercise::factory()->state(['skill' => SkillType::Language, 'passage' => null]), 'exercise')->create($attributes);
    }

    public function test_a_reorder_question_is_marked_on_the_sentence_built(): void
    {
        $question = $this->question(['type' => QuestionType::Reorder, 'prompt' => 'school / go / I / to', 'options' => null, 'answer' => 'I go to school.']);

        $this->assertSame(['school', 'go', 'I', 'to'], $question->scrambledWords());
        $this->assertTrue($question->isCorrect('I go to school'));
        $this->assertFalse($question->isCorrect('I to go school'));
    }

    public function test_a_rewrite_question_accepts_every_wording_the_teacher_listed(): void
    {
        $question = $this->question([
            'type' => QuestionType::Rewrite,
            'prompt' => 'My house is small. (bigger)',
            'options' => null,
            'answer' => 'Your house is bigger than mine.',
            'accepted_answers' => ['Your house is bigger than my house.'],
        ]);

        $this->assertTrue($question->isCorrect('your house is bigger than mine'));
        $this->assertTrue($question->isCorrect('Your house is bigger than my house.'));
        $this->assertFalse($question->isCorrect('My house is bigger.'));
        $this->assertFalse($question->isCorrect(''));
    }

    public function test_alternatives_only_count_for_rewrite_questions(): void
    {
        $question = $this->question(['type' => QuestionType::GapFill, 'prompt' => 'I ___ a cat.', 'options' => null, 'answer' => 'have', 'accepted_answers' => ['has']]);

        $this->assertFalse($question->isCorrect('has'));
    }

    public function test_marking_covers_matching_and_pronunciation_questions(): void
    {
        $exercise = SkillExercise::factory()->create(['skill' => SkillType::Language, 'passage' => null]);
        $matching = $exercise->questions()->create(['type' => QuestionType::Matching, 'prompt' => 'How are you?', 'options' => ['Fine, thanks.', 'It is red.'], 'answer' => 'Fine, thanks.', 'sort_order' => 1]);
        $sound = $exercise->questions()->create(['type' => QuestionType::Pronunciation, 'prompt' => 'Odd one out', 'options' => ['b[oo]k', 'l[oo]k', 'f[oo]d'], 'answer' => 'f[oo]d', 'sort_order' => 2]);

        $attempt = app(SubmitExerciseAttempt::class)->handle(User::factory()->student()->create(), $exercise, [
            $matching->id => 'Fine, thanks.',
            $sound->id => 'l[oo]k',
        ]);

        $this->assertSame(1, $attempt->score);
        $this->assertSame(2, $attempt->max_score);
    }

    public function test_marked_parts_are_underlined_and_the_rest_is_escaped(): void
    {
        $html = Blade::render('<x-marked :text="$text" />', ['text' => 'b[oo]k <script>']);

        $this->assertStringContainsString('b<u class="decoration-2 underline-offset-4">oo</u>k', $html);
        $this->assertStringContainsString('&lt;script&gt;', $html);
        $this->assertStringNotContainsString('<script>', $html);

        $plain = Blade::render('<x-marked :text="$text" :marks="false" />', ['text' => 'Rewrite it. [Begin with: Your bag]']);
        $this->assertStringContainsString('[Begin with: Your bag]', $plain);
        $this->assertStringNotContainsString('<u', $plain);
    }

    public function test_the_student_sees_word_tiles_for_a_reorder_question_and_a_list_for_matching(): void
    {
        $exercise = SkillExercise::factory()->create(['skill' => SkillType::Language, 'passage' => null]);
        $exercise->questions()->create(['type' => QuestionType::Reorder, 'prompt' => 'school / go / I / to', 'answer' => 'I go to school', 'sort_order' => 1]);
        $exercise->questions()->create(['type' => QuestionType::Matching, 'prompt' => 'How are you?', 'options' => ['Fine, thanks.', 'It is red.'], 'answer' => 'Fine, thanks.', 'sort_order' => 2]);

        $this->actingAs(User::factory()->student()->create())
            ->get(route('exercises.show', $exercise))
            ->assertOk()
            ->assertSee(__('skills.reorder_tap'))
            ->assertSee((string) Js::from(['school', 'go', 'I', 'to']), false)
            ->assertSee('<option value="Fine, thanks.">', false);
    }

    public function test_the_editor_refuses_a_reorder_answer_that_uses_other_words(): void
    {
        $exercise = SkillExercise::factory()->create(['skill' => SkillType::Language, 'passage' => null]);
        $exercise->questions()->create(['type' => QuestionType::Reorder, 'prompt' => 'school / go / I / to', 'answer' => 'I go to school', 'sort_order' => 1]);

        Livewire::actingAs(User::factory()->teacher()->create())
            ->test(EditExercise::class, ['exercise' => $exercise])
            ->set('questions.0.answer', 'I walk to school')
            ->call('save')
            ->assertHasErrors('questions.0.answer');

        $this->assertSame('I go to school', $exercise->questions()->first()->answer);
    }

    public function test_saving_stores_alternatives_and_clears_the_needs_check_mark(): void
    {
        $exercise = SkillExercise::factory()->create(['skill' => SkillType::Language, 'passage' => null]);
        $exercise->questions()->create(['type' => QuestionType::Rewrite, 'prompt' => 'My house is small. (bigger)', 'answer' => 'Your house is bigger than mine.', 'needs_check' => true, 'sort_order' => 1]);

        Livewire::actingAs(User::factory()->teacher()->create())
            ->test(EditExercise::class, ['exercise' => $exercise])
            ->assertSee(__('skills.needs_check'))
            ->set('questions.0.accepted_answers', "Your house is bigger than my house.\n")
            ->call('save')
            ->assertHasNoErrors();

        $question = $exercise->questions()->first();
        $this->assertSame(['Your house is bigger than my house.'], $question->accepted_answers);
        $this->assertFalse($question->needs_check);
    }
}
