<?php

namespace App\Actions\Roleplay;

use App\Enums\MessageRole;
use App\Models\Conversation;
use App\Models\RoleplayScenario;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StartRoleplay
{
    /**
     * Open a conversation with the scenario's scripted opening line, so the student sees the AI's
     * first message instantly without waiting for the provider.
     */
    public function handle(User $student, RoleplayScenario $scenario): Conversation
    {
        return DB::transaction(function () use ($student, $scenario) {
            $conversation = Conversation::create([
                'user_id' => $student->id,
                'roleplay_scenario_id' => $scenario->id,
            ]);

            $conversation->messages()->create([
                'role' => MessageRole::Assistant,
                'content' => $scenario->opening_line,
            ]);

            return $conversation;
        });
    }
}
