<?php

namespace Tests\Feature\Roleplay;

use App\Enums\MessageRole;
use App\Livewire\Roleplay\ConversationPage;
use App\Models\Conversation;
use App\Models\RoleplayScenario;
use App\Models\SentencePattern;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class RoleplayHintTest extends TestCase
{
    use RefreshDatabase;

    private function conversationFor(User $student): Conversation
    {
        $topic = Topic::factory()->create();
        SentencePattern::factory()->for($topic)->create(['english' => 'How much is this?']);
        $scenario = RoleplayScenario::factory()->for($topic)->create(['ai_role' => 'shop assistant']);

        $conversation = Conversation::factory()->for($student)->for($scenario, 'scenario')->create();
        $conversation->messages()->create(['role' => MessageRole::Assistant, 'content' => 'Hello! Can I help you?']);

        return $conversation;
    }

    private function fakeHint(): void
    {
        $payload = json_encode(['english' => 'Yes, I am looking for a T-shirt.', 'vietnamese' => 'Vâng, em đang tìm một chiếc áo phông.']);

        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => $payload]]]])]);
    }

    public function test_student_gets_a_sentence_with_its_vietnamese_meaning(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);
        $this->fakeHint();

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('suggest')
            ->assertSee('Yes, I am looking for a T-shirt.')
            ->assertSee('Vâng, em đang tìm một chiếc áo phông.');
    }

    public function test_hint_can_be_dropped_into_the_message_box(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);
        $this->fakeHint();

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('suggest')
            ->call('useHint')
            ->assertSet('message', 'Yes, I am looking for a T-shirt.')
            ->assertSet('hint', null);
    }

    public function test_hint_prompt_includes_the_partners_last_line_and_no_student_name(): void
    {
        $student = User::factory()->student()->create(['name' => 'Nguyễn Văn An', 'username' => 'hs.nguyenvanan']);
        $conversation = $this->conversationFor($student);
        // The newest partner line must win over the opening line.
        $conversation->messages()->create(['role' => MessageRole::Student, 'content' => 'How much is this T-shirt?']);
        $conversation->messages()->create(['role' => MessageRole::Assistant, 'content' => 'It is 150,000 dong. Would you like a bag?']);
        $this->fakeHint();

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('suggest');

        Http::assertSent(function (Request $request) {
            $body = $request->body();

            $prompt = $request->data()['messages'][1]['content'];

            return str_contains($prompt, 'The partner just said: "It is 150,000 dong. Would you like a bag?"')
                && str_contains($prompt, 'Me: How much is this T-shirt?')
                && ! str_contains($body, 'Nguy')
                && ! str_contains($body, 'hs.nguyenvanan');
        });
    }

    public function test_ai_failure_leaves_no_hint_and_shows_a_message(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);
        Http::fake(['openrouter.ai/*' => Http::response(['error' => 'overloaded'], 503)]);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('suggest')
            ->assertSet('hint', null)
            ->assertSee('Trợ lý đang bận, em thử lại sau nhé');
    }

    public function test_another_student_cannot_ask_for_a_hint(): void
    {
        Http::fake();
        $owner = User::factory()->student()->create();
        $intruder = User::factory()->student()->create();
        $conversation = $this->conversationFor($owner);

        Livewire::actingAs($intruder)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->assertForbidden();

        Http::assertNothingSent();
    }
}
