<?php

namespace Database\Seeders;

use App\Enums\QuestionType;
use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Models\CurriculumUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Ship ready-made reading, listening and writing practice for every unit (AM-023).
 *
 * Non-destructive: a unit that already has an exercise for a skill is left alone, so a teacher's
 * edits survive re-seeding. Seeded exercises are PUBLISHED, because they are reviewed content that
 * ships with the product rather than a fresh AI draft.
 */
class UnitExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/unit_exercises.php');

        if (! file_exists($path)) {
            $this->command?->warn('No exercise seed file yet — run: php artisan curriculum:build-exercise-seed');

            return;
        }

        $seed = require $path;
        $created = 0;

        DB::transaction(function () use ($seed, &$created) {
            foreach (CurriculumUnit::query()->inOrder()->get() as $unit) {
                foreach ($seed["{$unit->grade}-{$unit->number}"] ?? [] as $skill => $data) {
                    $skill = SkillType::from($skill);

                    if ($unit->exercises()->where('skill', $skill->value)->exists()) {
                        continue;
                    }

                    $exercise = $unit->exercises()->create([
                        'skill' => $skill,
                        'title_en' => $data['title_en'],
                        'title_vi' => $data['title_vi'],
                        'instructions_en' => $data['instructions_en'],
                        'instructions_vi' => $data['instructions_vi'],
                        'passage' => $data['passage'],
                        'prompt_en' => $data['prompt_en'],
                        'prompt_vi' => $data['prompt_vi'],
                        'min_words' => $data['min_words'],
                        'status' => TopicStatus::Published,
                        'sort_order' => 1,
                    ]);

                    foreach ($data['questions'] as $i => $question) {
                        $exercise->questions()->create([
                            'type' => QuestionType::from($question['type']),
                            'prompt' => $question['prompt'],
                            'options' => $question['options'],
                            'answer' => $question['answer'],
                            'explanation_vi' => $question['explanation_vi'],
                            'sort_order' => $i + 1,
                        ]);
                    }

                    $created++;
                }
            }
        });

        $this->command?->info("Unit exercises seeded: {$created}.");
    }
}
