<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
{
    public function view(User $user, Conversation $conversation): bool
    {
        return $conversation->user_id === $user->id;
    }

    public function sendMessage(User $user, Conversation $conversation): bool
    {
        return $conversation->user_id === $user->id;
    }

    /**
     * Ask the AI for feedback on, or a hint inside, this conversation.
     */
    public function practise(User $user, Conversation $conversation): bool
    {
        return $conversation->user_id === $user->id;
    }
}
