<?php

namespace App\Actions\Roleplay;

use App\Enums\MessageRole;
use App\Exceptions\AiUnavailableException;
use App\Exceptions\RoleplayTurnLimitReachedException;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Services\Ai\OpenRouterClient;
use Illuminate\Support\Facades\DB;

class SendRoleplayMessage
{
    public function __construct(private readonly OpenRouterClient $ai) {}

    /**
     * Send the student's message to the AI and store both sides of the exchange.
     *
     * The AI is called before anything is written: if it fails, nothing is stored and the student
     * can retry the same message.
     *
     * @throws AiUnavailableException
     * @throws RoleplayTurnLimitReachedException
     */
    public function handle(Conversation $conversation, string $text): ConversationMessage
    {
        if ($conversation->hasReachedTurnLimit()) {
            throw new RoleplayTurnLimitReachedException;
        }

        $conversation->loadMissing('scenario.topic.sentencePatterns');
        $history = $conversation->messages()->get();

        $messages = [['role' => 'system', 'content' => $this->systemPrompt($conversation)]];

        foreach ($history as $message) {
            $messages[] = ['role' => $message->role->apiRole(), 'content' => $message->content];
        }

        $messages[] = ['role' => MessageRole::Student->apiRole(), 'content' => $text];

        $reply = $this->ai->chat($messages, maxTokens: 150);

        return DB::transaction(function () use ($conversation, $text, $reply) {
            $conversation->messages()->create(['role' => MessageRole::Student, 'content' => $text]);
            $conversation->touch();

            return $conversation->messages()->create(['role' => MessageRole::Assistant, 'content' => $reply]);
        });
    }

    /**
     * Only the scenario and topic are sent to the provider — never the student's name or account.
     */
    private function systemPrompt(Conversation $conversation): string
    {
        $scenario = $conversation->scenario;
        $patterns = $scenario->topic->sentencePatterns->pluck('english')->implode("\n- ");

        return <<<PROMPT
        You are a friendly English conversation partner for Vietnamese lower-secondary students (age 11-15, CEFR A1-A2).

        Role-play situation: {$scenario->title_en}.
        You play: {$scenario->ai_role}. The student plays: {$scenario->student_role}.

        Rules:
        - Stay in your role for the whole conversation.
        - Reply in simple English only, 1-2 short sentences, then usually ask a question to keep the conversation going.
        - Use vocabulary a 12-year-old learner knows. Prefer these useful sentences when natural:
        - {$patterns}
        - Do not correct grammar explicitly; model the correct form naturally in your reply.
        - The setting is Vietnam: use dong for prices (e.g. "150,000 dong"), and places and food a Vietnamese student knows.
        - If the student writes something off-topic, rude or unsafe, do not engage with it. Politely bring the conversation back to the situation.
        - Never ask for or mention personal information such as full name, address, phone number or school.
        PROMPT;
    }
}
