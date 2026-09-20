<?php

namespace App\Console\Commands;

use App\Actions\Curriculum\SuggestUnitFocus;
use App\Exceptions\AiUnavailableException;
use App\Models\CurriculumUnit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Build the shipped vocabulary/grammar seed for every unit, once, so that no teacher has to
 * sit and generate 48 units by hand. The result is written to a seed file and committed;
 * teachers then only correct what does not match their book.
 */
class BuildUnitFocusSeed extends Command
{
    protected $signature = 'curriculum:build-focus-seed
        {--grade=* : Only these grades (default: all)}
        {--only-missing : Skip units already present in the seed file}';

    protected $description = 'Draft vocabulary and grammar for syllabus units and write them to the seed file';

    public function handle(SuggestUnitFocus $suggestUnitFocus): int
    {
        $path = database_path('seeders/data/unit_focus.php');
        $existing = File::exists($path) ? require $path : [];

        $units = CurriculumUnit::query()
            ->when($this->option('grade'), fn ($q, $grades) => $q->whereIn('grade', $grades))
            ->inOrder()
            ->get();

        $failed = [];

        foreach ($units as $unit) {
            $key = "{$unit->grade}-{$unit->number}";

            if ($this->option('only-missing') && isset($existing[$key])) {
                $this->line("  skip  {$key} {$unit->title_en}");

                continue;
            }

            try {
                $focus = $suggestUnitFocus->handle($unit);
            } catch (AiUnavailableException $e) {
                $failed[] = $key;
                $this->warn("  FAIL  {$key} {$unit->title_en}: {$e->getMessage()}");

                continue;
            }

            $existing[$key] = [
                'grammar_en' => $focus['grammar_en'],
                'grammar_vi' => $focus['grammar_vi'],
                'vocabulary' => $focus['vocabulary'],
            ];

            $words = substr_count($focus['vocabulary'], "\n") + 1;
            $this->info("  ok    {$key} {$unit->title_en} — {$words} words");

            // Written after every unit, so an interrupted run keeps what it already produced.
            $this->write($path, $existing);
        }

        $this->newLine();
        $this->line('Seed file: '.$path);
        $this->line('Units in file: '.count($existing));

        if ($failed !== []) {
            $this->warn('Failed: '.implode(', ', $failed).' — re-run with --only-missing to fill the gaps.');

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    /**
     * @param  array<string, array{grammar_en: string, grammar_vi: string, vocabulary: string}>  $data
     */
    private function write(string $path, array $data): void
    {
        ksort($data, SORT_NATURAL);

        $header = <<<'PHP'
        <?php

        /*
         * Starting vocabulary and grammar for every unit of Tiếng Anh 6–9 (Global Success).
         *
         * Drafted with `php artisan curriculum:build-focus-seed` so that the product ships with
         * content instead of asking every teacher to generate it. These are NOT the book's own word
         * lists (ADR-0005): they are the words usually taught for that topic at that level. Teachers
         * correct them against their book in the unit page, and their edits are never overwritten by
         * the seeder.
         *
         * Key: "<grade>-<unit number>".
         */

        return
        PHP;

        File::put($path, $header.' '.$this->export($data).";\n");
    }

    /**
     * var_export with the short array syntax, so the file matches the project's style.
     */
    private function export(array $data): string
    {
        $exported = var_export($data, true);
        $exported = preg_replace('/^(\s*)array \(/m', '$1[', $exported);
        $exported = preg_replace('/^(\s*)\),?$/m', '$1],', $exported);
        $exported = preg_replace('/=>\s*\n\s*\[/', '=> [', $exported);

        return rtrim(rtrim(trim($exported), ','), ']').']';
    }
}
