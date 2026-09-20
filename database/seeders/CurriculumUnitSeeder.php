<?php

namespace Database\Seeders;

use App\Models\CurriculumUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Idempotent: the syllabus skeleton for grades 6–9. AM-016.
 */
class CurriculumUnitSeeder extends Seeder
{
    public function run(): void
    {
        $grades = require database_path('seeders/data/curriculum_units.php');

        DB::transaction(function () use ($grades) {
            foreach ($grades as $grade => $units) {
                foreach ($units as [$number, $emoji, $titleEn, $titleVi, $focusVi, $focusEn]) {
                    CurriculumUnit::updateOrCreate(
                        ['grade' => $grade, 'number' => $number],
                        [
                            'term' => $number <= 6 ? 1 : 2,
                            'emoji' => $emoji,
                            'title_en' => $titleEn,
                            'title_vi' => $titleVi,
                            'focus_vi' => $focusVi,
                            'focus_en' => $focusEn,
                        ],
                    );
                }
            }
        });
    }
}
