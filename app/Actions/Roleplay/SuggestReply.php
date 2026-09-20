<?php

namespace App\Actions\Roleplay;

use App\Enums\MessageRole;
use App\Exceptions\AiUnavailableException;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Services\Ai\OpenRouterClient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class SuggestReply
{
    public function __construct(private readonly OpenRouterClient $ai) {}

    /**
     * Suggest one sentence the student could say next, with its Vietnamese meaning.
     *
     * @return array{english: string, vietnamese: string}
     *
     * @throws AiUnavailableException
     */
    public function handle(Conversation $conversation): array
    {
        $conversation->loadMissing('scenario.topic.sentencePatterns');
        $scenario = $conversation->scenario;
        // reorder() drops the relation's ascending order, otherwise latest() is ignored and the
        // hint is built from the opening line instead of what was just said.
        $recent = $conversation->messages()->reorder()->latest('id')->limit(4)->get()->reverse();
        $lastFromPartner = $recent->last(fn ($message) => $message->role === MessageRole::Assistant)?->content
            ?? $conversation->scenario->opening_line;
        $patterns = $scenario->topic->sentencePatterns->pluck('english')->implode("\n- ");

        $answer = $this->ai->chat([
            ['role' => 'system', 'content' => <<<PROMPT
            A Vietnamese lower-secondary student (CEFR A1-A2) is stuck in an English role-play and needs one thing to say next.

            Situation: {$scenario->title_en}. The student plays: {$scenario->student_role}. The partner plays: {$scenario->ai_role}.
            Useful sentences from this topic:
            - {$patterns}

            Reply with JSON only, no markdown fence: {"english": "<one short sentence the student can say next>", "vietnamese": "<its Vietnamese meaning>"}
            The sentence must fit the situation, be at most 12 words, and use simple words.
            PROMPT],
            ['role' => 'user', 'content' => "So far:\n{$this->transcript($recent)}\n\nThe partner just said: \"{$lastFromPartner}\". What can I say next?"],
        ], maxTokens: 120, temperature: 0.4);

        return $this->decode($answer);
    }

    /**
     * @param  Collection<int, ConversationMessage>  $messages
     */
    private function transcript($messages): string
    {
        return $messages
            ->map(fn ($message) => ($message->role === MessageRole::Assistant ? 'Partner: ' : 'Me: ').$message->content)
            ->implode("\n");
    }

    /**
     * @return array{english: string, vietnamese: string}
     */
    private function decode(string $answer): array
    {
        $json = trim(preg_replace('/^```(?:json)?|```$/m', '', $answer));
        $payload = json_decode($json, true);

        if (! is_array($payload) || ! filled($payload['english'] ?? null)) {
            Log::warning('Hint could not be parsed', ['answer' => mb_substr($answer, 0, 300)]);

            throw new AiUnavailableException('The hint could not be parsed.');
        }

        return [
            'english' => mb_substr(trim((string) $payload['english']), 0, 200),
            'vietnamese' => mb_substr(trim((string) ($payload['vietnamese'] ?? '')), 0, 200),
        ];
    }
}
