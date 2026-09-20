<?php

namespace Tests\Feature\Curriculum;

use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Models\CurriculumUnit;
use App\Models\ExerciseQuestion;
use App\Models\SkillExercise;
use Database\Seeders\CurriculumUnitSeeder;
use Database\Seeders\UnitExerciseSeeder;
use Database\Seeders\UnitFocusSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnitExerciseSeederTest extends TestCase
{
    use RefreshDatabase;

    private function seedAll(): void
    {
        $this->seed(CurriculumUnitSeeder::class);
        $this->seed(UnitFocusSeeder::class);
        $this->seed(UnitExerciseSeeder::class);
    }

    public function test_every_unit_ships_with_reading_listening_and_writing_practice(): void
    {
        $this->seedAll();

        $this->assertSame(144, SkillExercise::count(), '48 units × 3 skills');

        foreach ([SkillType::Reading, SkillType::Listening, SkillType::Writing] as $skill) {
            $this->assertSame(48, SkillExercise::where('skill', $skill->value)->count(), $skill->value);
        }

        $this->assertSame(0, SkillExercise::where('status', TopicStatus::Draft->value)->count(), 'shipped practice is ready to use');
    }

    public function test_reading_and_listening_carry_a_passage_and_questions(): void
    {
        $this->seedAll();

        SkillExercise::with('questions')
            ->whereIn('skill', [SkillType::Reading->value, SkillType::Listening->value])
            ->get()
            ->each(function (SkillExercise $exercise) {
                $this->assertNotEmpty($exercise->passage, "exercise {$exercise->id} has no passage");
                $this->assertGreaterThanOrEqual(3, $exercise->questions->count(), "exercise {$exercise->id} has too few questions");
            });
    }

    public function test_every_choice_question_has_its_answer_among_the_options(): void
    {
        $this->seedAll();

        ExerciseQuestion::all()->each(function (ExerciseQuestion $question) {
            if ($question->type->hasOptions()) {
                $this->assertContains($question->answer, $question->options, "question {$question->id} is unanswerable");
            }
        });
    }

    public function test_writing_tasks_carry_a_prompt_and_a_length(): void
    {
        $this->seedAll();

        SkillExercise::where('skill', SkillType::Writing->value)->get()->each(function (SkillExercise $exercise) {
            $this->assertNotEmpty($exercise->prompt_en, "exercise {$exercise->id} has no task");
            $this->assertNotEmpty($exercise->prompt_vi);
            $this->assertGreaterThanOrEqual(30, $exercise->min_words);
        });
    }

    public function test_re_seeding_adds_nothing_and_keeps_a_teachers_edit(): void
    {
        $this->seedAll();
        $exercise = SkillExercise::where('skill', SkillType::Reading->value)->firstOrFail();
        $exercise->update(['title_vi' => 'Bài cô Hoa sửa lại']);

        $this->seed(UnitExerciseSeeder::class);

        $this->assertSame(144, SkillExercise::count());
        $this->assertSame('Bài cô Hoa sửa lại', $exercise->fresh()->title_vi);
    }

    public function test_grade_8_shopping_practice_uses_the_unit_words(): void
    {
        $this->seedAll();

        $unit = CurriculumUnit::where('grade', 8)->where('number', 8)->firstOrFail();
        $reading = $unit->exercises()->where('skill', SkillType::Reading->value)->firstOrFail();
        $words = $unit->vocabulary->pluck('word')->map(fn ($w) => strtolower($w));

        $used = $words->filter(fn ($word) => str_contains(strtolower($reading->passage), $word));

        $this->assertGreaterThanOrEqual(3, $used->count(), 'the passage should use the unit vocabulary');
    }
}
