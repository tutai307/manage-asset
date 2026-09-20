<?php

namespace App\Console\Commands;

use App\Actions\Skills\GenerateSkillExercise;
use App\Enums\SkillType;
use App\Exceptions\AiUnavailableException;
use App\Models\CurriculumUnit;
use App\Models\SkillExercise;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Build the shipped reading/listening/writing practice for every unit, once (AM-023).
 *
 * The exercises are written to a seed file and committed, so a new installation has practice for
 * all 48 units without a single AI call, and teachers spend their time correcting rather than
 * generating. Speaking is the role-play and is not generated here.
 */
class BuildUnitExerciseSeed extends Command
{
    protected $signature = 'curriculum:build-exercise-seed
        {--grade=* : Only these grades (default: all)}
        {--skill=* : Only these skills (default: reading, listening, writing)}
        {--only-missing : Skip units that already have this skill in the seed file}';

    protected $description = 'Draft one exercise per skill per unit and write them to the seed file';

    public function handle(GenerateSkillExercise $generateSkillExercise): int
    {
        $path = database_path('seeders/data/unit_exercises.php');
        $seed = File::exists($path) ? require $path : [];

        $skills = $this->option('skill')
            ? array_map(fn (string $s) => SkillType::from($s), $this->option('skill'))
            : [SkillType::Reading, SkillType::Listening, SkillType::Writing];

        $units = CurriculumUnit::query()
            ->when($this->option('grade'), fn ($q, $grades) => $q->whereIn('grade', $grades))
            ->with('vocabulary')
            ->inOrder()
            ->get();

        $failed = [];

        foreach ($units as $unit) {
            $key = "{$unit->grade}-{$unit->number}";

            if (! $unit->hasApprovedFocus()) {
                $this->warn("  skip  {$key} — no vocabulary yet, run curriculum:build-focus-seed first");

                continue;
            }

            foreach ($skills as $skill) {
                if ($this->option('only-missing') && isset($seed[$key][$skill->value])) {
                    continue;
                }

                try {
                    // Generated into the database inside a transaction, read back, then rolled
                    // back: the seed file is the artefact, not this machine's database.
                    $exercise = null;
                    DB::transaction(function () use (&$exercise, $generateSkillExercise, $unit, $skill) {
                        $exercise = $generateSkillExercise->handle($unit, $skill)->load('questions');

                        throw new RollbackSignal;
                    });
                } catch (RollbackSignal) {
                    // expected
                } catch (AiUnavailableException $e) {
                    $failed[] = "{$key}/{$skill->value}";
                    $this->warn("  FAIL  {$key} {$skill->value}: {$e->getMessage()}");

                    continue;
                }

                $seed[$key][$skill->value] = $this->toArray($exercise);
                $this->info("  ok    {$key} {$unit->title_en} — {$skill->value}: \"{$exercise->title_en}\" ({$exercise->questions->count()} q)");

                $this->write($path, $seed);
            }
        }

        $this->newLine();
        $this->line('Seed file: '.$path);
        $this->line('Units in file: '.count($seed));

        if ($failed !== []) {
            $this->warn('Failed: '.implode(', ', $failed).' — re-run with --only-missing.');

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    /**
     * @return array<string, mixed>
     */
    private function toArray(SkillExercise $exercise): array
    {
        return [
            'title_en' => $exercise->title_en,
            'title_vi' => $exercise->title_vi,
            'instructions_en' => $exercise->instructions_en,
            'instructions_vi' => $exercise->instructions_vi,
            'passage' => $exercise->passage,
            'prompt_en' => $exercise->prompt_en,
            'prompt_vi' => $exercise->prompt_vi,
            'min_words' => $exercise->min_words,
            'questions' => $exercise->questions->map(fn ($question) => [
                'type' => $question->type->value,
                'prompt' => $question->prompt,
                'options' => $question->options,
                'answer' => $question->answer,
                'explanation_vi' => $question->explanation_vi,
            ])->all(),
        ];
    }

    private function write(string $path, array $seed): void
    {
        ksort($seed, SORT_NATURAL);

        $header = <<<'PHP'
        <?php

        /*
         * Reading, listening and writing practice for every unit of Tiếng Anh 6–9 (Global Success).
         *
         * Drafted with `php artisan curriculum:build-exercise-seed`, written fresh from each unit's
         * vocabulary — never copied from a textbook (ADR-0005). Shipped so that a new installation
         * has practice for all 48 units without any AI call. Teachers edit these in the unit page;
         * the seeder never touches a unit that already has exercises.
         *
         * Key: "<grade>-<unit number>" => "<skill>" => exercise.
         */

        return
        PHP;

        $exported = var_export($seed, true);
        $exported = preg_replace('/^(\s*)array \(/m', '$1[', $exported);
        $exported = preg_replace('/^(\s*)\),?$/m', '$1],', $exported);
        $exported = preg_replace('/=>\s*\n\s*\[/', '=> [', $exported);
        $exported = rtrim(rtrim(trim($exported), ','), ']').']';

        File::put($path, $header.' '.$exported.";\n");
    }
}

/**
 * Internal marker used to roll back the generated rows after reading them.
 */
class RollbackSignal extends \RuntimeException {}
