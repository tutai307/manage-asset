<?php

namespace Tests\Feature\Roleplay;

use App\Actions\Roleplay\StartRoleplay;
use App\Enums\Companion;
use App\Enums\MessageRole;
use App\Livewire\Roleplay\ConversationPage;
use App\Models\Conversation;
use App\Models\RoleplayScenario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class CompanionTest extends TestCase
{
    use RefreshDatabase;

    private function conversationFor(User $student, ?Companion $companion = Companion::Miu): Conversation
    {
        $scenario = RoleplayScenario::factory()->create(['ai_role' => 'shop assistant', 'opening_line' => 'Hello! Can I help you?']);
        $conversation = Conversation::factory()->for($student)->for($scenario, 'scenario')->create(['companion' => $companion]);
        $conversation->messages()->create(['role' => MessageRole::Assistant, 'content' => 'Hello! Can I help you?']);

        return $conversation;
    }

    private function fakeAiReply(string $reply): void
    {
        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => $reply]]]])]);
    }

    public function test_a_student_without_a_companion_is_asked_to_choose_before_the_call(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student, null);

        $this->actingAs($student)
            ->get(route('conversations.show', $conversation))
            ->assertOk()
            ->assertSee(__('companions.choose_title'))
            ->assertSee(Companion::Oli->name())
            ->assertDontSee(__('companions.call_start', ['name' => Companion::Miu->name()]));
    }

    public function test_the_chosen_companion_is_remembered_and_plays_the_next_role_play(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student, null);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('chooseCompanion', 'oli')
            ->assertSee(__('companions.call_start', ['name' => Companion::Oli->name()]));

        $this->assertSame(Companion::Oli, $student->fresh()->companion);
        $this->assertSame(Companion::Oli, $conversation->fresh()->companion);

        $next = app(StartRoleplay::class)->handle($student->fresh(), RoleplayScenario::factory()->create());
        $this->assertSame(Companion::Oli, $next->companion);
    }

    public function test_an_unknown_companion_is_ignored(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student, null);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('chooseCompanion', 'pikachu');

        $this->assertNull($student->fresh()->companion);
        $this->assertNull($conversation->fresh()->companion);
    }

    public function test_a_student_cannot_choose_the_companion_of_another_students_conversation(): void
    {
        $owner = User::factory()->student()->create();
        $intruder = User::factory()->student()->create();
        $conversation = $this->conversationFor($owner, null);

        Livewire::actingAs($intruder)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->assertForbidden();

        $this->assertNull($conversation->fresh()->companion);
    }

    public function test_the_ai_gets_the_companions_personality_but_not_the_students_name(): void
    {
        $student = User::factory()->student()->create(['name' => 'Trần Thị Bình', 'username' => 'hs.tranthibinh']);
        $conversation = $this->conversationFor($student, Companion::Robo);
        $this->fakeAiReply('Beep boop! What size do you need?');

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->set('message', 'I want a T-shirt.')
            ->call('send');

        Http::assertSent(function (Request $request) {
            $body = json_encode($request->data(), JSON_UNESCAPED_UNICODE);

            return str_contains($body, 'Robo, a clumsy, funny cartoon robot')
                && str_contains($body, 'shop assistant')
                && str_contains($body, 'no emojis')
                && ! str_contains($body, 'Trần Thị Bình')
                && ! str_contains($body, 'hs.tranthibinh');
        });
    }

    public function test_the_call_screen_is_told_the_reply_and_whether_the_call_is_over(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);
        $this->fakeAiReply('Sure! Which colour?');

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->set('message', 'I want a T-shirt.')
            ->call('send')
            ->assertDispatched('companion-replied', text: 'Sure! Which colour?', finished: false);

        foreach (range(2, Conversation::MAX_STUDENT_TURNS - 1) as $i) {
            $conversation->messages()->create(['role' => MessageRole::Student, 'content' => "Line {$i}"]);
        }

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->set('message', 'Thank you, bye!')
            ->call('send')
            ->assertDispatched('companion-replied', finished: true);
    }

    public function test_an_ai_failure_tells_the_call_screen_to_pause(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student);
        Http::fake(['openrouter.ai/*' => Http::response([], 503)]);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->set('message', 'I want a T-shirt.')
            ->call('send')
            ->assertDispatched('companion-failed')
            ->assertNotDispatched('companion-replied');
    }

    public function test_the_call_carries_the_companions_voice_and_the_line_to_open_with(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationFor($student, Companion::Dino);

        $this->actingAs($student)
            ->get(route('conversations.show', $conversation))
            ->assertOk()
            ->assertSee('data-voice="'.e(json_encode(Companion::Dino->voice())).'"', false)
            ->assertSee('data-opening="Hello! Can I help you?"', false)
            ->assertSee('data-finished="0"', false);
    }
}
