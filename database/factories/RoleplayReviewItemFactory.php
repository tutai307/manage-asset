<?php

namespace Database\Factories;

use App\Models\RoleplayReview;
use App\Models\RoleplayReviewItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoleplayReviewItem>
 */
class RoleplayReviewItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'roleplay_review_id' => RoleplayReview::factory(),
            'conversation_message_id' => null,
            'original' => 'How much this T-shirt?',
            'is_good' => false,
            'better_en' => 'How much is this T-shirt?',
            'note_vi' => 'Câu hỏi cần có động từ "is".',
            'note_en' => 'The question needs the verb "is".',
            'sort_order' => 1,
        ];
    }

    public function good(): static
    {
        return $this->state(fn () => [
            'original' => 'Can I try it on?',
            'is_good' => true,
            'better_en' => null,
            'note_vi' => null,
            'note_en' => null,
        ]);
    }
}
