<?php

namespace Database\Factories;

use App\Enums\Companion;
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
            'companion' => Companion::Miu,
        ];
    }

    /**
     * A conversation started before the student picked a companion.
     */
    public function withoutCompanion(): static
    {
        return $this->state(['companion' => null]);
    }
}
