<?php

namespace Database\Factories;

use App\Models\CurriculumUnit;
use App\Models\UnitVocabulary;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UnitVocabulary>
 */
class UnitVocabularyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'curriculum_unit_id' => CurriculumUnit::factory(),
            'word' => fake()->unique()->word(),
            'part_of_speech' => 'n',
            'meaning_vi' => 'nghĩa tiếng Việt',
            'sort_order' => 1,
        ];
    }
}
