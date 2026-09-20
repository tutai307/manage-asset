<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\RoleplayReview;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoleplayReview>
 */
class RoleplayReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'conversation_id' => Conversation::factory(),
            'model' => 'anthropic/claude-haiku-4.5',
            'good_count' => 2,
            'reviewed_count' => 3,
            'summary_vi' => 'Em nói khá tốt. Hãy chú ý thêm mạo từ "a" và "the".',
            'summary_en' => 'Good job. Watch the articles "a" and "the".',
        ];
    }
}
