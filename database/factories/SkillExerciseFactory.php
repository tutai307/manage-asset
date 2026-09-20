<?php

namespace Database\Factories;

use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Models\CurriculumUnit;
use App\Models\SkillExercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SkillExercise>
 */
class SkillExerciseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'curriculum_unit_id' => CurriculumUnit::factory(),
            'skill' => SkillType::Reading,
            'title_en' => 'At the market',
            'title_vi' => 'Ở chợ',
            'instructions_en' => 'Read the text and answer the questions.',
            'instructions_vi' => 'Đọc đoạn văn rồi trả lời câu hỏi.',
            'passage' => 'Lan goes to the market on Sunday. She buys some fruit and a new shirt.',
            'status' => TopicStatus::Published,
            'model' => 'anthropic/claude-haiku-4.5',
            'sort_order' => 1,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => TopicStatus::Draft]);
    }

    public function listening(): static
    {
        return $this->state(fn () => [
            'skill' => SkillType::Listening,
            'passage' => "Nam: How much is this hat?\nSeller: It is 50,000 dong.",
        ]);
    }

    public function writing(): static
    {
        return $this->state(fn () => [
            'skill' => SkillType::Writing,
            'passage' => null,
            'prompt_en' => 'Write about your last shopping trip.',
            'prompt_vi' => 'Viết về lần đi mua sắm gần đây của em.',
            'min_words' => 50,
        ]);
    }
}
