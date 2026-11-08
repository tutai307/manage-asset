<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\SkillExercise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'skill_exercise_id' => SkillExercise::factory(),
            'classroom_id' => Classroom::factory(),
            'assigned_by' => User::factory()->teacher(),
            'due_at' => null,
        ];
    }
}
