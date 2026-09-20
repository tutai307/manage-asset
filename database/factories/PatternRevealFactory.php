<?php

namespace Database\Factories;

use App\Models\PatternReveal;
use App\Models\SentencePattern;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PatternReveal>
 */
class PatternRevealFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->student(),
            'sentence_pattern_id' => SentencePattern::factory(),
        ];
    }
}
