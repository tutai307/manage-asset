<?php

namespace Database\Factories;

use App\Enums\TopicStatus;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Topic>
 */
class TopicFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->words(2, true);

        return [
            'slug' => Str::slug($title),
            'title_en' => Str::title($title),
            'title_vi' => 'Chủ đề '.$title,
            'description_vi' => 'Luyện các câu giao tiếp thông dụng.',
            'status' => TopicStatus::Published,
            'sort_order' => 0,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => TopicStatus::Draft]);
    }
}
