<?php

namespace Tests\Feature\Roleplay;

use App\Enums\MessageRole;
use App\Livewire\Roleplay\ConversationPage;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\RoleplayReview;
use App\Models\RoleplayScenario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class RoleplayReviewTest extends TestCase
{
    use RefreshDatabase;

    private function conversationWithSentences(User $student, int $sentences = 2): Conversation
    {
        $scenario = RoleplayScenario::factory()->create(['title_vi' => 'Mua áo phông']);
        $conversation = Conversation::factory()->for($student)->for($scenario, 'scenario')->create();
        $conversation->messages()->create(['role' => MessageRole::Assistant, 'content' => 'Hello! Can I help you?']);

        foreach (range(1, $sentences) as $i) {
            $conversation->messages()->create(['role' => MessageRole::Student, 'content' => "How much this T-shirt {$i}?"]);
        }

        return $conversation;
    }

    private function fakeReview(): void
    {
        $payload = json_encode([
            'sentences' => [
                ['original' => 'How much this T-shirt 1?', 'is_good' => false, 'better_en' => 'How much is this T-shirt?', 'note_vi' => 'Câu hỏi cần động từ "is".', 'note_en' => 'The question needs "is".'],
                ['original' => 'How much this T-shirt 2?', 'is_good' => true, 'better_en' => null, 'note_vi' => null, 'note_en' => null],
            ],
            'summary_vi' => 'Em nói khá tốt, chú ý thêm động từ "to be".',
            'summary_en' => 'Good work, watch the verb "to be".',
        ]);

        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => $payload]]]])]);
    }

    public function test_student_receives_marked_sentences_and_a_summary(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationWithSentences($student);
        $this->fakeReview();

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('review')
            ->assertSee('How much is this T-shirt?')
            ->assertSee('Câu hỏi cần động từ &quot;is&quot;.', false)
            ->assertSee('Em nói khá tốt, chú ý thêm động từ "to be".');

        $review = RoleplayReview::firstOrFail();
        $this->assertSame($conversation->id, $review->conversation_id);
        $this->assertSame(1, $review->good_count);
        $this->assertSame(2, $review->reviewed_count);
        $this->assertDatabaseCount('roleplay_review_items', 2);
        $this->assertDatabaseHas('roleplay_review_items', ['is_good' => false, 'better_en' => 'How much is this T-shirt?']);
    }

    public function test_review_request_sends_the_sentences_but_not_the_student_name(): void
    {
        $student = User::factory()->student()->create(['name' => 'Nguyễn Văn An', 'username' => 'hs.nguyenvanan']);
        $conversation = $this->conversationWithSentences($student);
        $this->fakeReview();

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('review');

        Http::assertSent(function (Request $request) {
            $body = $request->body();

            return str_contains($request->data()['messages'][1]['content'], 'How much this T-shirt 1?')
                && ! str_contains($body, 'Nguy')
                && ! str_contains($body, 'hs.nguyenvanan');
        });
    }

    public function test_a_conversation_with_one_sentence_is_too_short_to_review(): void
    {
        Http::fake();
        $student = User::factory()->student()->create();
        $conversation = $this->conversationWithSentences($student, sentences: 1);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('review')
            ->assertSee('Em cần nói ít nhất 2 câu');

        Http::assertNothingSent();
        $this->assertDatabaseCount('roleplay_reviews', 0);
    }

    public function test_unparseable_ai_answer_shows_a_message_and_stores_nothing(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationWithSentences($student);
        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => 'Sure! Here is my feedback…']]]])]);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('review')
            ->assertSee('Chưa lấy được nhận xét');

        $this->assertDatabaseCount('roleplay_reviews', 0);
    }

    public function test_ai_failure_shows_a_message_and_stores_nothing(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationWithSentences($student);
        Http::fake(['openrouter.ai/*' => Http::response(['error' => 'overloaded'], 503)]);

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('review')
            ->assertSee('Chưa lấy được nhận xét');

        $this->assertDatabaseCount('roleplay_reviews', 0);
    }

    public function test_another_student_cannot_review_someone_elses_conversation(): void
    {
        Http::fake();
        $owner = User::factory()->student()->create();
        $intruder = User::factory()->student()->create();
        $conversation = $this->conversationWithSentences($owner);

        Livewire::actingAs($intruder)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->assertForbidden();

        Http::assertNothingSent();
        $this->assertDatabaseCount('roleplay_reviews', 0);
    }

    public function test_only_the_latest_review_is_shown(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationWithSentences($student);
        $old = RoleplayReview::factory()->for($conversation)->create(['summary_vi' => 'Nhận xét cũ', 'summary_en' => 'Old feedback']);
        $this->fakeReview();

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('review')
            ->assertSee('Em nói khá tốt, chú ý thêm động từ "to be".')
            ->assertDontSee('Nhận xét cũ');

        // The earlier review is kept: review history is append-only.
        $this->assertDatabaseHas('roleplay_reviews', ['id' => $old->id]);
        $this->assertDatabaseCount('roleplay_reviews', 2);
    }

    public function test_review_of_a_finished_conversation_is_still_possible(): void
    {
        $student = User::factory()->student()->create();
        $conversation = $this->conversationWithSentences($student);
        ConversationMessage::factory()
            ->count(Conversation::MAX_STUDENT_TURNS)
            ->for($conversation)
            ->create(['role' => MessageRole::Student]);
        $this->fakeReview();

        Livewire::actingAs($student)
            ->test(ConversationPage::class, ['conversation' => $conversation])
            ->call('review')
            ->assertSee(__('review.title'));

        $this->assertDatabaseCount('roleplay_reviews', 1);
    }
}
