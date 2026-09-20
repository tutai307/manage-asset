<?php

namespace Tests\Feature\Topics;

use App\Enums\SupportLevel;
use App\Livewire\Topics\Index;
use App\Livewire\Topics\Show;
use App\Models\Conversation;
use App\Models\RoleplayScenario;
use App\Models\SentencePattern;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TopicLearningTest extends TestCase
{
    use RefreshDatabase;

    private function shoppingTopic(): Topic
    {
        $topic = Topic::factory()->create(['slug' => 'shopping', 'title_en' => 'Shopping', 'title_vi' => 'Mua sắm']);
        SentencePattern::factory()->for($topic)->create(['english' => 'How much is this?', 'vietnamese' => 'Cái này giá bao nhiêu?']);

        return $topic;
    }

    public function test_student_sees_english_and_vietnamese_at_full_support(): void
    {
        $student = User::factory()->student()->create();
        $topic = $this->shoppingTopic();

        $this->actingAs($student)
            ->get(route('topics.show', $topic))
            ->assertOk()
            ->assertSee('How much is this?')
            ->assertSee('Cái này giá bao nhiêu?');
    }

    public function test_english_only_hides_vietnamese_until_revealed_and_records_the_reveal(): void
    {
        $student = User::factory()->student()->create();
        $topic = $this->shoppingTopic();
        $pattern = $topic->sentencePatterns()->first();

        $component = Livewire::actingAs($student)
            ->test(Show::class, ['topic' => $topic])
            ->call('setSupportLevel', SupportLevel::EnglishOnly->value)
            ->assertSee('How much is this?')
            ->assertDontSee('Cái này giá bao nhiêu?');

        $component->call('reveal', $pattern->id)->assertSee('Cái này giá bao nhiêu?');

        $this->assertDatabaseHas('pattern_reveals', ['user_id' => $student->id, 'sentence_pattern_id' => $pattern->id]);
    }

    public function test_revealing_the_same_pattern_twice_in_one_visit_records_once(): void
    {
        $student = User::factory()->student()->create();
        $topic = $this->shoppingTopic();
        $pattern = $topic->sentencePatterns()->first();

        Livewire::actingAs($student)
            ->test(Show::class, ['topic' => $topic])
            ->call('setSupportLevel', SupportLevel::EnglishOnly->value)
            ->call('reveal', $pattern->id)
            ->call('reveal', $pattern->id);

        $this->assertDatabaseCount('pattern_reveals', 1);
    }

    public function test_cannot_reveal_a_pattern_from_another_topic(): void
    {
        $student = User::factory()->student()->create();
        $topic = $this->shoppingTopic();
        $foreignPattern = SentencePattern::factory()->create();

        $component = Livewire::actingAs($student)->test(Show::class, ['topic' => $topic]);

        $this->assertThrows(
            fn () => $component->call('reveal', $foreignPattern->id),
            ModelNotFoundException::class,
        );

        $this->assertDatabaseCount('pattern_reveals', 0);
    }

    public function test_draft_topic_returns_404_for_a_student(): void
    {
        $student = User::factory()->student()->create();
        $draft = Topic::factory()->draft()->create(['slug' => 'weather']);

        $this->actingAs($student)->get(route('topics.show', $draft))->assertNotFound();
    }

    public function test_teacher_can_preview_a_draft_topic(): void
    {
        $teacher = User::factory()->teacher()->create();
        $draft = Topic::factory()->draft()->create(['slug' => 'weather', 'title_en' => 'Weather']);

        $this->actingAs($teacher)->get(route('topics.show', $draft))->assertOk()->assertSee('Weather');
    }

    public function test_draft_topics_are_hidden_from_the_student_topic_list(): void
    {
        $student = User::factory()->student()->create();
        Topic::factory()->create(['title_en' => 'Shopping']);
        Topic::factory()->draft()->create(['title_en' => 'Weather']);

        Livewire::actingAs($student)
            ->test(Index::class)
            ->assertSee('Shopping')
            ->assertDontSee('Weather');
    }

    public function test_student_is_not_allowed_to_update_a_topic(): void
    {
        $student = User::factory()->student()->create();
        $teacher = User::factory()->teacher()->create();
        $topic = $this->shoppingTopic();

        $this->assertTrue($student->cannot('update', $topic));
        $this->assertTrue($teacher->can('update', $topic));
    }

    public function test_starting_a_roleplay_creates_a_conversation_with_the_opening_line(): void
    {
        $student = User::factory()->student()->create();
        $topic = $this->shoppingTopic();
        $scenario = RoleplayScenario::factory()->for($topic)->create(['opening_line' => 'Hello! Can I help you?']);

        Livewire::actingAs($student)
            ->test(Show::class, ['topic' => $topic])
            ->call('startRoleplay', $scenario->id)
            ->assertRedirect(route('conversations.show', Conversation::firstOrFail()));

        $conversation = Conversation::firstOrFail();
        $this->assertSame($student->id, $conversation->user_id);
        $this->assertDatabaseHas('conversation_messages', [
            'conversation_id' => $conversation->id,
            'role' => 'assistant',
            'content' => 'Hello! Can I help you?',
        ]);
    }
}
