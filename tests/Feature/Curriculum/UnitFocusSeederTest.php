<?php

namespace Tests\Feature\Curriculum;

use App\Models\CurriculumUnit;
use App\Models\UnitVocabulary;
use Database\Seeders\CurriculumUnitSeeder;
use Database\Seeders\UnitFocusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitFocusSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_unit_of_every_grade_ships_with_vocabulary_and_grammar(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $this->seed(UnitFocusSeeder::class);

        $this->assertSame(0, CurriculumUnit::where('focus_approved', false)->count(), 'every unit should be filled');
        $this->assertSame(0, CurriculumUnit::whereNull('grammar_en')->count());
        $this->assertGreaterThan(500, UnitVocabulary::count());

        CurriculumUnit::withCount('vocabulary')->get()->each(
            fn (CurriculumUnit $unit) => $this->assertGreaterThanOrEqual(10, $unit->vocabulary_count, "grade {$unit->grade} unit {$unit->number}"),
        );
    }

    public function test_seeding_twice_does_not_duplicate_words(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $this->seed(UnitFocusSeeder::class);
        $before = UnitVocabulary::count();

        $this->seed(UnitFocusSeeder::class);

        $this->assertSame($before, UnitVocabulary::count());
    }

    public function test_the_seeder_never_overwrites_what_a_teacher_approved(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $unit = CurriculumUnit::where('grade', 8)->where('number', 8)->firstOrFail();
        $unit->update(['focus_approved' => true, 'grammar_en' => 'The teacher wrote this']);
        $unit->vocabulary()->create(['word' => 'bargain', 'meaning_vi' => 'mặc cả', 'sort_order' => 1]);

        $this->seed(UnitFocusSeeder::class);

        $unit->refresh();
        $this->assertSame('The teacher wrote this', $unit->grammar_en);
        $this->assertSame(['bargain'], $unit->vocabulary->pluck('word')->all());
    }

    public function test_shopping_unit_carries_words_a_teacher_would_expect(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $this->seed(UnitFocusSeeder::class);

        $words = CurriculumUnit::where('grade', 8)->where('number', 8)->firstOrFail()
            ->vocabulary->pluck('word')->map(fn ($w) => strtolower($w))->all();

        foreach (['price', 'size', 'discount'] as $expected) {
            $this->assertContains($expected, $words);
        }
    }
}
