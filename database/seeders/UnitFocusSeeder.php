<?php

namespace Database\Seeders;

use App\Actions\Curriculum\SaveUnitFocus;
use App\Models\CurriculumUnit;
use Illuminate\Database\Seeder;

/**
 * Ship every unit with a starting word list and grammar point (AM-023).
 *
 * Idempotent and non-destructive: a unit the teacher has already approved is left alone, so
 * re-running the seeder never overwrites their corrections.
 */
class UnitFocusSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/unit_focus.php');

        if (! file_exists($path)) {
            $this->command?->warn('No unit focus seed file yet — run: php artisan curriculum:build-focus-seed');

            return;
        }

        $focus = require $path;
        $save = app(SaveUnitFocus::class);
        $filled = 0;

        foreach (CurriculumUnit::query()->inOrder()->get() as $unit) {
            $entry = $focus["{$unit->grade}-{$unit->number}"] ?? null;

            if ($entry === null || $unit->focus_approved) {
                continue;
            }

            $save->handle($unit, $entry['vocabulary'], $entry['grammar_en'], $entry['grammar_vi']);
            $filled++;
        }

        $this->command?->info("Unit focus seeded for {$filled} units.");
    }
}
