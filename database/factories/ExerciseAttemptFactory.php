<?php

namespace Database\Factories;

use App\Models\ExerciseAttempt;
use App\Models\SkillExercise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExerciseAttempt>
 */
class ExerciseAttemptFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->student(),
            'skill_exercise_id' => SkillExercise::factory(),
            'score' => 4,
            'max_score' => 5,
            'answers' => [],
        ];
    }
}
