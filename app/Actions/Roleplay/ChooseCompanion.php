<?php

namespace App\Actions\Roleplay;

use App\Enums\Companion;
use App\Models\Conversation;
use Illuminate\Support\Facades\DB;

class ChooseCompanion
{
    /**
     * Remember the student's companion and let it play this conversation from the next reply on.
     */
    public function handle(Conversation $conversation, Companion $companion): void
    {
        DB::transaction(function () use ($conversation, $companion) {
            $conversation->user->update(['companion' => $companion]);
            $conversation->update(['companion' => $companion]);
        });
    }
}
