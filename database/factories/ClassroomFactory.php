<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Classroom>
 */
class ClassroomFactory extends Factory
{
    public function definition(): array
    {
        $grade = fake()->numberBetween(6, 9);

        return [
            'teacher_id' => User::factory()->teacher(),
            'name' => $grade.fake()->unique()->randomElement(['A', 'B', 'C', 'D', 'E', 'G', 'H', 'K']),
            'grade' => $grade,
        ];
    }
}
