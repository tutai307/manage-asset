<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\RoleplayScenario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Conversation>
 */
class ConversationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->student(),
            'roleplay_scenario_id' => RoleplayScenario::factory(),
        ];
    }
}
