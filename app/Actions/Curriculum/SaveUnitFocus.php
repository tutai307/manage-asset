<?php

namespace App\Actions\Curriculum;

use App\Models\CurriculumUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaveUnitFocus
{
    /**
     * Replace a unit's vocabulary list and grammar focus with what the teacher entered.
     *
     * The teacher pastes the word list of the unit they are teaching, one entry per line:
     *   word = nghĩa tiếng Việt
     *   word (n) = nghĩa tiếng Việt
     *
     * @return int the number of words stored
     */
    public function handle(CurriculumUnit $unit, string $rawVocabulary, ?string $grammarEn, ?string $grammarVi): int
    {
        $entries = $this->parse($rawVocabulary);

        DB::transaction(function () use ($unit, $entries, $grammarEn, $grammarVi) {
            $unit->vocabulary()->delete();

            foreach ($entries as $i => $entry) {
                $unit->vocabulary()->create([
                    'word' => $entry['word'],
                    'part_of_speech' => $entry['part_of_speech'],
                    'meaning_vi' => $entry['meaning_vi'],
                    'sort_order' => $i + 1,
                ]);
            }

            $unit->update([
                'grammar_en' => $grammarEn ? mb_substr(trim($grammarEn), 0, 500) : null,
                'grammar_vi' => $grammarVi ? mb_substr(trim($grammarVi), 0, 500) : null,
                'focus_approved' => $entries !== [],
            ]);
        });

        return count($entries);
    }

    /**
     * @return list<array{word: string, part_of_speech: ?string, meaning_vi: string}>
     */
    public function parse(string $raw): array
    {
        $entries = [];
        $seen = [];

        foreach (preg_split('/\R/u', $raw) as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            // "word (n) = nghĩa" — the separator may be =, :, - or a dash.
            [$left, $right] = array_pad(preg_split('/\s*(?:=|:|—|–|\s-\s)\s*/u', $line, 2), 2, null);

            $partOfSpeech = null;
            if (preg_match('/\(([^)]{1,12})\)\s*$/u', trim((string) $left), $matches)) {
                $partOfSpeech = trim($matches[1]);
                $left = trim(preg_replace('/\(([^)]{1,12})\)\s*$/u', '', $left));
            }

            $word = mb_substr(trim((string) $left), 0, 100);
            $meaning = mb_substr(trim((string) $right), 0, 200);

            if ($word === '' || $meaning === '') {
                continue;
            }

            $key = Str::lower($word);
            if (isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;
            $entries[] = ['word' => $word, 'part_of_speech' => $partOfSpeech, 'meaning_vi' => $meaning];
        }

        return $entries;
    }
}
