<?php

namespace App\Actions\Roleplay;

use App\Enums\MessageRole;
use App\Exceptions\AiUnavailableException;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\RoleplayReview;
use App\Services\Ai\OpenRouterClient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewRoleplay
{
    /**
     * At least this many student sentences before feedback is worth asking for.
     */
    public const MIN_STUDENT_TURNS = 2;

    public function __construct(private readonly OpenRouterClient $ai) {}

    /**
     * Ask the AI to mark each sentence the student wrote, then store the review.
     *
     * @throws AiUnavailableException
     */
    public function handle(Conversation $conversation): RoleplayReview
    {
        $sentences = $conversation->messages()
            ->where('role', MessageRole::Student->value)
            ->orderBy('id')
            ->get();

        if ($sentences->count() < self::MIN_STUDENT_TURNS) {
            throw new AiUnavailableException('Not enough student sentences to review.');
        }

        $answer = $this->ai->chat([
            ['role' => 'system', 'content' => $this->systemPrompt()],
            ['role' => 'user', 'content' => $this->sentenceList($sentences)],
        ], maxTokens: 900, temperature: 0.2);

        $payload = $this->decode($answer);

        return DB::transaction(function () use ($conversation, $sentences, $payload) {
            $items = collect($payload['sentences'])->take($sentences->count());

            $review = RoleplayReview::create([
                'conversation_id' => $conversation->id,
                'model' => (string) config('services.openrouter.model'),
                'good_count' => $items->where('is_good', true)->count(),
                'reviewed_count' => $items->count(),
                'summary_vi' => $payload['summary_vi'],
                'summary_en' => $payload['summary_en'],
            ]);

            $items->each(function (array $item, int $index) use ($review, $sentences) {
                $review->items()->create([
                    'conversation_message_id' => $sentences[$index]->id ?? null,
                    'original' => $sentences[$index]->content ?? $item['original'],
                    'is_good' => $item['is_good'],
                    'better_en' => $item['better_en'],
                    'note_vi' => $item['note_vi'],
                    'note_en' => $item['note_en'],
                    'sort_order' => $index + 1,
                ]);
            });

            return $review->load('items');
        });
    }

    private function systemPrompt(): string
    {
        return <<<'PROMPT'
        You are an English teacher marking short sentences written by a Vietnamese lower-secondary student (CEFR A1-A2) during a role-play.

        For each numbered sentence, decide whether it is good enough for a real conversation.
        Be encouraging: small slips that a listener would still understand count as good.

        Reply with JSON only, no markdown fence, in exactly this shape:
        {
          "sentences": [
            {"original": "<the sentence>", "is_good": true, "better_en": null, "note_vi": null, "note_en": null}
          ],
          "summary_vi": "<2 short sentences of encouragement and one thing to work on, in Vietnamese>",
          "summary_en": "<the same summary in simple English>"
        }

        Rules:
        - One array entry per numbered sentence, in the same order.
        - When is_good is false, better_en is a corrected version in simple English, and note_vi / note_en explain the fix in one short sentence each.
        - When is_good is true, better_en, note_vi and note_en are null.
        - Never mention the student's name or any personal detail.
        PROMPT;
    }

    /**
     * @param  Collection<int, ConversationMessage>  $sentences
     */
    private function sentenceList($sentences): string
    {
        return $sentences
            ->map(fn (ConversationMessage $message, int $index) => ($index + 1).'. '.$message->content)
            ->implode("\n");
    }

    /**
     * @return array{sentences: list<array{original: string, is_good: bool, better_en: ?string, note_vi: ?string, note_en: ?string}>, summary_vi: string, summary_en: string}
     */
    private function decode(string $answer): array
    {
        $json = trim(preg_replace('/^```(?:json)?|```$/m', '', $answer));
        $payload = json_decode($json, true);

        if (! is_array($payload) || ! isset($payload['sentences']) || ! is_array($payload['sentences']) || $payload['sentences'] === []) {
            Log::warning('Role-play review could not be parsed', ['answer' => mb_substr($answer, 0, 500)]);

            throw new AiUnavailableException('The review could not be parsed.');
        }

        return [
            'sentences' => array_map(fn ($item) => [
                'original' => (string) ($item['original'] ?? ''),
                'is_good' => (bool) ($item['is_good'] ?? true),
                'better_en' => $this->nullableString($item['better_en'] ?? null),
                'note_vi' => $this->nullableString($item['note_vi'] ?? null),
                'note_en' => $this->nullableString($item['note_en'] ?? null),
            ], array_values(array_filter($payload['sentences'], 'is_array'))),
            'summary_vi' => (string) ($payload['summary_vi'] ?? ''),
            'summary_en' => (string) ($payload['summary_en'] ?? ($payload['summary_vi'] ?? '')),
        ];
    }

    private function nullableString(mixed $value): ?string
    {
        $value = is_string($value) ? trim($value) : null;

        return ($value === null || $value === '') ? null : mb_substr($value, 0, 500);
    }
}
