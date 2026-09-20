<?php

namespace App\Actions\Curriculum;

use App\Enums\TopicStatus;
use App\Exceptions\AiUnavailableException;
use App\Models\CurriculumUnit;
use App\Models\Topic;
use App\Services\Ai\OpenRouterClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * AM-017: draft a bilingual practice pack for one syllabus unit.
 *
 * The AI writes original sentences for the unit's topic. Nothing is copied from the textbook, and
 * the result is a DRAFT: students see it only after a teacher publishes it.
 */
class GenerateUnitTopic
{
    public function __construct(private readonly OpenRouterClient $ai) {}

    /**
     * @throws AiUnavailableException
     */
    public function handle(CurriculumUnit $unit): Topic
    {
        $answer = $this->ai->chat([
            ['role' => 'system', 'content' => $this->systemPrompt()],
            ['role' => 'user', 'content' => $this->unitBrief($unit)],
        ], maxTokens: 1600, temperature: 0.5);

        $payload = $this->decode($answer);

        return DB::transaction(function () use ($unit, $payload) {
            $topic = Topic::create([
                'curriculum_unit_id' => $unit->id,
                'slug' => $this->uniqueSlug($unit),
                'emoji' => $unit->emoji,
                'title_en' => $unit->title_en,
                'title_vi' => $unit->title_vi,
                'description_vi' => $payload['description_vi'],
                'description_en' => $payload['description_en'],
                'status' => TopicStatus::Draft,
                'sort_order' => 100 + $unit->number,
            ]);

            foreach ($payload['patterns'] as $i => $pattern) {
                $topic->sentencePatterns()->create([
                    'english' => $pattern['english'],
                    'vietnamese' => $pattern['vietnamese'],
                    'note_vi' => $pattern['note_vi'],
                    'sort_order' => $i + 1,
                ]);
            }

            foreach ($payload['scenarios'] as $i => $scenario) {
                $topic->roleplayScenarios()->create([
                    'title_en' => $scenario['title_en'],
                    'title_vi' => $scenario['title_vi'],
                    'situation_vi' => $scenario['situation_vi'],
                    'situation_en' => $scenario['situation_en'],
                    'ai_role' => $scenario['ai_role'],
                    'student_role' => $scenario['student_role'],
                    'opening_line' => $scenario['opening_line'],
                    'sort_order' => $i + 1,
                ]);
            }

            return $topic->load(['sentencePatterns', 'roleplayScenarios']);
        });
    }

    private function systemPrompt(): string
    {
        return <<<'PROMPT'
        You write original English practice material for Vietnamese lower-secondary students.

        Write your own sentences for the given unit topic. Never reproduce text, exercises or reading
        passages from any textbook; use the topic only as the theme.

        Reply with JSON only, no markdown fence:
        {
          "description_vi": "<one sentence in Vietnamese saying what the student will practise>",
          "description_en": "<the same in simple English>",
          "patterns": [
            {"english": "<a useful sentence>", "vietnamese": "<its Vietnamese meaning>", "note_vi": "<a short Vietnamese tip, or null>"}
          ],
          "scenarios": [
            {
              "title_en": "<short situation name>",
              "title_vi": "<the same in Vietnamese>",
              "situation_vi": "<2 sentences in Vietnamese telling the student what is happening>",
              "situation_en": "<the same in simple English>",
              "ai_role": "<who the AI plays, in English>",
              "student_role": "<who the student plays, in English>",
              "opening_line": "<the first line the AI says, in simple English>"
            }
          ]
        }

        Rules:
        - Exactly 10 patterns and exactly 2 scenarios.
        - Sentences must be ones a student really says in that situation, at the level given.
        - Vietnamese must be natural, not word-by-word translation.
        - The setting is Vietnam: dong for prices, Vietnamese places and food.
        - note_vi is null unless a short tip genuinely helps.
        PROMPT;
    }

    private function unitBrief(CurriculumUnit $unit): string
    {
        $level = match (true) {
            $unit->grade <= 6 => 'CEFR A1',
            $unit->grade <= 8 => 'CEFR A1-A2',
            default => 'CEFR A2',
        };

        return "Grade {$unit->grade}, Unit {$unit->number}: \"{$unit->title_en}\" ({$unit->title_vi}).\n"
            ."What the students practise: {$unit->focus_en}\n"
            ."Level: {$level}. Students are {$this->ageFor($unit->grade)} years old.";
    }

    private function ageFor(int $grade): string
    {
        return match ($grade) {
            6 => '11-12',
            7 => '12-13',
            8 => '13-14',
            default => '14-15',
        };
    }

    private function uniqueSlug(CurriculumUnit $unit): string
    {
        $base = "lop-{$unit->grade}-unit-{$unit->number}-".Str::slug(Str::ascii($unit->title_en));
        $slug = $base;
        $suffix = 2;

        while (Topic::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    /**
     * @return array{description_vi: string, description_en: string, patterns: list<array{english: string, vietnamese: string, note_vi: ?string}>, scenarios: list<array<string, string>>}
     */
    private function decode(string $answer): array
    {
        $json = trim(preg_replace('/^```(?:json)?|```$/m', '', $answer));
        $payload = json_decode($json, true);

        $patterns = array_values(array_filter($payload['patterns'] ?? [], fn ($p) => is_array($p) && filled($p['english'] ?? null) && filled($p['vietnamese'] ?? null)));
        $scenarios = array_values(array_filter($payload['scenarios'] ?? [], fn ($s) => is_array($s) && filled($s['title_en'] ?? null) && filled($s['opening_line'] ?? null)));

        if (count($patterns) < 6 || count($scenarios) < 1) {
            Log::warning('Unit content could not be parsed', ['answer' => mb_substr($answer, 0, 500)]);

            throw new AiUnavailableException('The generated unit content could not be parsed.');
        }

        return [
            'description_vi' => (string) ($payload['description_vi'] ?? ''),
            'description_en' => (string) ($payload['description_en'] ?? ''),
            'patterns' => array_map(fn ($p) => [
                'english' => mb_substr(trim($p['english']), 0, 255),
                'vietnamese' => mb_substr(trim($p['vietnamese']), 0, 255),
                'note_vi' => filled($p['note_vi'] ?? null) ? mb_substr(trim($p['note_vi']), 0, 255) : null,
            ], $patterns),
            'scenarios' => array_map(fn ($s) => [
                'title_en' => mb_substr(trim($s['title_en']), 0, 150),
                'title_vi' => mb_substr(trim($s['title_vi'] ?? $s['title_en']), 0, 150),
                'situation_vi' => trim($s['situation_vi'] ?? ''),
                'situation_en' => trim($s['situation_en'] ?? ''),
                'ai_role' => mb_substr(trim($s['ai_role'] ?? 'a friendly partner'), 0, 100),
                'student_role' => mb_substr(trim($s['student_role'] ?? 'a student'), 0, 100),
                'opening_line' => mb_substr(trim($s['opening_line']), 0, 255),
            ], $scenarios),
        ];
    }
}
