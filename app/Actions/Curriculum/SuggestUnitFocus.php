<?php

namespace App\Actions\Curriculum;

use App\Exceptions\AiUnavailableException;
use App\Models\CurriculumUnit;
use App\Services\Ai\OpenRouterClient;
use Illuminate\Support\Facades\Log;

/**
 * Draft a starting point for a unit's vocabulary and grammar, which the teacher then corrects
 * against the book. It is a suggestion, never the source of truth: `focus_approved` is only set
 * when the teacher saves the list.
 */
class SuggestUnitFocus
{
    public function __construct(private readonly OpenRouterClient $ai) {}

    /**
     * @return array{vocabulary: string, grammar_en: string, grammar_vi: string}
     *
     * @throws AiUnavailableException
     */
    public function handle(CurriculumUnit $unit): array
    {
        $answer = $this->ai->chat([
            ['role' => 'system', 'content' => <<<'PROMPT'
            You help a Vietnamese English teacher prepare a unit. Given a grade and a unit topic from the
            lower-secondary syllabus, suggest the vocabulary and the grammar point students usually learn
            for that topic at that level.

            Do not reproduce any textbook page; give the words a teacher would expect for this topic.

            Reply with JSON only, no markdown fence:
            {"vocabulary": [{"word": "...", "part_of_speech": "n/v/adj/adv/phrase", "meaning_vi": "..."}],
             "grammar_en": "<the grammar point in English, max 120 characters>",
             "grammar_vi": "<the same in Vietnamese>"}

            Give 12 to 18 words, in the order they would be taught.
            PROMPT],
            ['role' => 'user', 'content' => "Grade {$unit->grade}, Unit {$unit->number}: \"{$unit->title_en}\" ({$unit->title_vi}). Focus: {$unit->focus_en}"],
        ], maxTokens: 900, temperature: 0.3);

        $json = trim(preg_replace('/^```(?:json)?|```$/m', '', $answer));
        $payload = json_decode($json, true);
        $words = array_filter($payload['vocabulary'] ?? [], fn ($w) => is_array($w) && filled($w['word'] ?? null) && filled($w['meaning_vi'] ?? null));

        if (count($words) < 6) {
            Log::warning('Unit focus suggestion could not be parsed', ['answer' => mb_substr($answer, 0, 400)]);

            throw new AiUnavailableException('The unit focus could not be parsed.');
        }

        $lines = array_map(function (array $word) {
            $pos = filled($word['part_of_speech'] ?? null) ? ' ('.trim($word['part_of_speech']).')' : '';

            return trim($word['word']).$pos.' = '.trim($word['meaning_vi']);
        }, $words);

        return [
            'vocabulary' => implode("\n", $lines),
            'grammar_en' => mb_substr(trim((string) ($payload['grammar_en'] ?? '')), 0, 500),
            'grammar_vi' => mb_substr(trim((string) ($payload['grammar_vi'] ?? '')), 0, 500),
        ];
    }
}
