<?php

namespace App\Livewire\Roleplay;

use App\Actions\Roleplay\ChooseCompanion;
use App\Actions\Roleplay\ReviewRoleplay;
use App\Actions\Roleplay\SendRoleplayMessage;
use App\Actions\Roleplay\SuggestReply;
use App\Enums\Companion;
use App\Enums\MessageRole;
use App\Exceptions\AiUnavailableException;
use App\Exceptions\RoleplayTurnLimitReachedException;
use App\Models\Conversation;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ConversationPage extends Component
{
    #[Locked]
    public int $conversationId;

    public string $message = '';

    public ?string $error = null;

    /** @var array{english: string, vietnamese: string}|null */
    public ?array $hint = null;

    public function mount(Conversation $conversation): void
    {
        Gate::authorize('view', $conversation);

        $this->conversationId = $conversation->id;
    }

    public function send(SendRoleplayMessage $sendRoleplayMessage): void
    {
        $conversation = $this->conversation();
        Gate::authorize('sendMessage', $conversation);

        $this->error = null;

        $validated = $this->validate(
            ['message' => ['required', 'string', 'max:300']],
            attributes: ['message' => __('roleplay.message')],
        );

        try {
            $reply = $sendRoleplayMessage->handle($conversation, trim($validated['message']));
        } catch (AiUnavailableException) {
            // Keep the typed message so the student can simply press send again.
            $this->error = __('roleplay.ai_unavailable');
            $this->dispatch('companion-failed');

            return;
        } catch (RoleplayTurnLimitReachedException) {
            $this->error = __('roleplay.turn_limit', ['max' => Conversation::MAX_STUDENT_TURNS]);
            $this->dispatch('companion-failed');

            return;
        }

        $this->reset('message', 'hint');

        // AM-025: the call screen speaks the reply and then listens again, unless the call is over.
        $this->dispatch('companion-replied', text: $reply->content, finished: $conversation->hasReachedTurnLimit());
    }

    /**
     * AM-024: pick the cartoon character that plays this conversation; remembered for next time.
     */
    public function chooseCompanion(string $companion, ChooseCompanion $chooseCompanion): void
    {
        $conversation = $this->conversation();
        Gate::authorize('sendMessage', $conversation);

        $chosen = Companion::tryFrom($companion);

        if ($chosen) {
            $chooseCompanion->handle($conversation, $chosen);
        }
    }

    /**
     * AM-008: suggest what the student could say next.
     */
    public function suggest(SuggestReply $suggestReply): void
    {
        $conversation = $this->conversation();
        Gate::authorize('practise', $conversation);

        $this->error = null;

        try {
            $this->hint = $suggestReply->handle($conversation);
        } catch (AiUnavailableException) {
            $this->hint = null;
            $this->error = __('roleplay.ai_unavailable');
        }
    }

    public function useHint(): void
    {
        if ($this->hint) {
            $this->message = $this->hint['english'];
            $this->hint = null;
        }
    }

    /**
     * AM-007: ask the AI to mark the sentences the student wrote.
     */
    public function review(ReviewRoleplay $reviewRoleplay): void
    {
        $conversation = $this->conversation();
        Gate::authorize('practise', $conversation);

        $this->error = null;

        if ($conversation->studentTurnCount() < ReviewRoleplay::MIN_STUDENT_TURNS) {
            $this->error = __('review.too_short', ['count' => ReviewRoleplay::MIN_STUDENT_TURNS]);

            return;
        }

        try {
            $reviewRoleplay->handle($conversation);
        } catch (AiUnavailableException) {
            $this->error = __('review.unavailable');
        }
    }

    public function render()
    {
        $conversation = Conversation::query()
            ->with(['scenario.topic', 'messages'])
            ->findOrFail($this->conversationId);

        $turnsUsed = $conversation->messages->where('role', MessageRole::Student)->count();

        return view('livewire.roleplay.conversation-page', [
            'conversation' => $conversation,
            'turnsUsed' => $turnsUsed,
            'maxTurns' => Conversation::MAX_STUDENT_TURNS,
            'canReview' => $turnsUsed >= ReviewRoleplay::MIN_STUDENT_TURNS,
            'review' => $conversation->latestReview(),
            'companion' => $conversation->companion,
            'companions' => Companion::cases(),
        ])->title($conversation->scenario->title());
    }

    private function conversation(): Conversation
    {
        return Conversation::query()->findOrFail($this->conversationId);
    }
}
