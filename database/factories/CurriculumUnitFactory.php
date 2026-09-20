<?php

namespace Database\Factories;

use App\Models\CurriculumUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CurriculumUnit>
 */
class CurriculumUnitFactory extends Factory
{
    public function definition(): array
    {
        $number = fake()->unique()->numberBetween(1, 12);

        return [
            'grade' => 8,
            'number' => $number,
            'term' => $number <= 6 ? 1 : 2,
            'emoji' => '📘',
            'title_en' => 'Shopping',
            'title_vi' => 'Mua sắm',
            'focus_vi' => 'Hỏi giá, chọn cỡ và mua đồ.',
            'focus_en' => 'Ask prices, choose sizes and buy things.',
        ];
    }

    public function grade(int $grade): static
    {
        return $this->state(fn () => ['grade' => $grade]);
    }
}
