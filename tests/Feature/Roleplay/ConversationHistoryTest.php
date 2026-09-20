<?php

namespace Tests\Feature\Roleplay;

use App\Livewire\Roleplay\History;
use App\Models\Conversation;
use App\Models\RoleplayScenario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ConversationHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_sees_only_their_own_conversations(): void
    {
        $student = User::factory()->student()->create();
        $other = User::factory()->student()->create();

        $mine = RoleplayScenario::factory()->create(['title_vi' => 'Mua áo phông']);
        $theirs = RoleplayScenario::factory()->create(['title_vi' => 'Hỏi đường']);

        Conversation::factory()->for($student)->for($mine, 'scenario')->create();
        Conversation::factory()->for($other)->for($theirs, 'scenario')->create();

        Livewire::actingAs($student)
            ->test(History::class)
            ->assertSee('Mua áo phông')
            ->assertDontSee('Hỏi đường');
    }

    public function test_empty_state_points_to_the_topic_list(): void
    {
        $student = User::factory()->student()->create();

        $this->actingAs($student)
            ->get(route('conversations.index'))
            ->assertOk()
            ->assertSee(__('dashboard.no_conversations'))
            ->assertSee(route('topics.index'), false);
    }
}
