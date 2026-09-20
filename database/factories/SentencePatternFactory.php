<?php

namespace Database\Factories;

use App\Models\SentencePattern;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SentencePattern>
 */
class SentencePatternFactory extends Factory
{
    public function definition(): array
    {
        return [
            'topic_id' => Topic::factory(),
            'english' => 'How are you?',
            'vietnamese' => 'Bạn có khoẻ không?',
            'note_vi' => null,
            'sort_order' => 0,
        ];
    }
}
