<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\ExerciseQuestion;
use App\Models\SkillExercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExerciseQuestion>
 */
class ExerciseQuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'skill_exercise_id' => SkillExercise::factory(),
            'type' => QuestionType::MultipleChoice,
            'prompt' => 'When does Lan go to the market?',
            'options' => ['On Sunday', 'On Monday', 'On Friday'],
            'answer' => 'On Sunday',
            'explanation_vi' => 'Đoạn văn nói Lan đi chợ vào Chủ nhật.',
            'sort_order' => 1,
        ];
    }

    public function gapFill(): static
    {
        return $this->state(fn () => [
            'type' => QuestionType::GapFill,
            'prompt' => 'Lan buys a new ___.',
            'options' => null,
            'answer' => 'shirt',
        ]);
    }
}
