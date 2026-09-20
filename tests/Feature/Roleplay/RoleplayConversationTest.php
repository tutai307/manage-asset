<?php

namespace Tests\Feature\Roleplay;

use App\Enums\MessageRole;
use App\Livewire\Roleplay\ConversationPage;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\RoleplayScenario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class RoleplayConversationTest extends TestCase
{
    use RefreshDatabase;

    private function conversationFor(User $student): Conversation
    {
        $scenario = RoleplayScenario::factory()->create([
            'title_en' => 'Buying a T-shirt',
            'title_vi' => 'Mua áo phông',
            'ai_role' => 'shop assistant',
            'opening_line' => 'Hello! Can I help you?',
        ]);

        $conversation = Conversation::factory()->for($student)->for($scenario, 'scenario')->create();
        $conversation->messages()->create(['role' => MessageRole::Assistant, 'content' => 'Hello! Can I help you?']);

        return $conversation;
    }

    private function fakeAiReply(string $reply): void
    {
        Http::fake([
            'openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => $reply]]]]),
        ]);
    }

    public function test_student_sends_a_message_and_the_ai_replies_in_role(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);
        $this->fakeAiReply("It's 150,000 dong. What colour would you like?");

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->set('message', 'How much is this T-shirt?')
            ->call('send')
            ->assertHasNoErrors()
            ->assertSet('message', '')
            ->assertSee('How much is this T-shirt?')
            ->assertSee("It's 150,000 dong. What colour would you like?");

        $this->assertSame(
            ['assistant', 'student', 'assistant'],
            $conversation->messages()->pluck('role')->map->value->all(),
        );
    }

    public function test_request_to_ai_contains_role_and_history_but_not_the_students_name(): void
    {
        $student = User::factory()->student()->create(['name' => 'Nguyễn Văn An', 'username' => 'hs.nguyenvanan']);
        $conversation = $this->conversationFor($student);
        $this->fakeAiReply('Sure!');

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->set('message', 'How much is this T-shirt?')
            ->call('send');

        Http::assertSent(function (Request $request) {
            $body = $request->body();
            $messages = $request->data()['messages'];

            return $request->hasHeader('Authorization', 'Bearer test-key')
                && $messages[0]['role'] === 'system'
                && str_contains($messages[0]['content'], 'shop assistant')
                && end($messages)['content'] === 'How much is this T-shirt?'
                && ! str_contains($body, 'Nguy')
                && ! str_contains($body, 'hs.nguyenvanan');
        });
    }

    public function test_ai_failure_shows_busy_message_keeps_the_text_and_stores_nothing(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);
        Http::fake(['openrouter.ai/*' => Http::response(['error' => 'overloaded'], 503)]);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->set('message', 'How much is this T-shirt?')
            ->call('send')
            ->assertSet('message', 'How much is this T-shirt?')
            ->assertSee('Trợ lý đang bận, em thử lại sau nhé');

        $this->assertSame(1, $conversation->messages()->count());
    }

    public function test_missing_api_key_is_treated_as_ai_unavailable(): void
    {
        config(['services.openrouter.key' => null]);
        Http::fake();
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->set('message', 'Hello')
            ->call('send')
            ->assertSee('Trợ lý đang bận, em thử lại sau nhé');

        Http::assertNothingSent();
    }

    public function test_empty_message_is_rejected_without_calling_the_ai(): void
    {
        Http::fake();
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->set('message', '   ')
            ->call('send')
            ->assertHasErrors(['message']);

        Http::assertNothingSent();
    }

    public function test_conversation_stops_after_the_turn_limit(): void
    {
        Http::fake();
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);
        ConversationMessage::factory()
            ->count(Conversation::MAX_STUDENT_TURNS)
            ->for($conversation)
            ->create(['role' => MessageRole::Student]);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->set('message', 'One more?')
            ->call('send')
            ->assertSee('Tình huống này đã đủ 12 lượt.');

        Http::assertNothingSent();
    }

    public function test_student_cannot_open_another_students_conversation(): void
    {
        $owner = User::factory()->student()->create();
        $intruder = User::factory()->student()->create();
        $conversation = $this->conversationFor($owner);

        $this->actingAs($intruder)->get(route('conversations.show', $conversation))->assertForbidden();
    }

    public function test_owner_can_open_their_conversation_page(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);

        $this->actingAs($student)
            ->get(route('conversations.show', $conversation))
            ->assertOk()
            ->assertSee('Mua áo phông')
            ->assertSee('Hello! Can I help you?');
    }
}
