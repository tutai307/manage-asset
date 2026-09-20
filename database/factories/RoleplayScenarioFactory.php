<?php

namespace Database\Factories;

use App\Models\RoleplayScenario;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoleplayScenario>
 */
class RoleplayScenarioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'topic_id' => Topic::factory(),
            'title_en' => 'Buying a T-shirt',
            'title_vi' => 'Mua áo phông',
            'situation_vi' => 'Em vào cửa hàng quần áo và muốn mua một chiếc áo phông.',
            'ai_role' => 'shop assistant',
            'student_role' => 'customer',
            'opening_line' => 'Hello! Can I help you?',
            'sort_order' => 0,
        ];
    }
}
