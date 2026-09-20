<?php

namespace Tests\Feature\Topics;

use App\Enums\TopicStatus;
use App\Models\RoleplayScenario;
use App\Models\SentencePattern;
use App\Models\Topic;
use Database\Seeders\StarterTopicSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StarterTopicSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_twelve_published_topics_are_seeded(): void
    {
        $this->seed(StarterTopicSeeder::class);

        $this->assertSame(12, Topic::where('status', TopicStatus::Published->value)->count());
    }

    public function test_every_topic_has_at_least_eight_patterns_and_two_scenarios(): void
    {
        $this->seed(StarterTopicSeeder::class);

        Topic::withCount(['sentencePatterns', 'roleplayScenarios'])->get()->each(function (Topic $topic) {
            $this->assertGreaterThanOrEqual(8, $topic->sentence_patterns_count, $topic->slug);
            $this->assertSame(2, $topic->roleplay_scenarios_count, $topic->slug);
        });
    }

    public function test_shopping_topic_contains_the_price_question_with_exact_vietnamese(): void
    {
        $this->seed(StarterTopicSeeder::class);

        $shopping = Topic::where('slug', 'shopping')->firstOrFail();

        $this->assertDatabaseHas('sentence_patterns', [
            'topic_id' => $shopping->id,
            'english' => 'How much is this?',
            'vietnamese' => 'Cái này giá bao nhiêu?',
        ]);
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seed(StarterTopicSeeder::class);
        $counts = [Topic::count(), SentencePattern::count(), RoleplayScenario::count()];

        $this->seed(StarterTopicSeeder::class);

        $this->assertSame($counts, [Topic::count(), SentencePattern::count(), RoleplayScenario::count()]);
    }
}
