<?php

namespace Tests\Feature\Curriculum;

use App\Enums\TopicStatus;
use App\Livewire\Curriculum\Show;
use App\Models\CurriculumUnit;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class GenerateUnitTopicTest extends TestCase
{
    use RefreshDatabase;

    private function unit(): CurriculumUnit
    {
        return CurriculumUnit::factory()->create([
            'grade' => 8,
            'number' => 8,
            'title_en' => 'Shopping',
            'title_vi' => 'Mua sắm',
            'focus_en' => 'Ask prices, choose sizes, buy and return things.',
        ]);
    }

    private function fakeGeneratedPack(): void
    {
        $patterns = [];
        foreach (range(1, 10) as $i) {
            $patterns[] = ['english' => "Sentence number {$i}?", 'vietnamese' => "Câu số {$i}?", 'note_vi' => null];
        }

        $payload = json_encode([
            'description_vi' => 'Luyện hỏi giá và mua đồ.',
            'description_en' => 'Practise asking prices and buying things.',
            'patterns' => $patterns,
            'scenarios' => [
                [
                    'title_en' => 'At the market', 'title_vi' => 'Ở chợ',
                    'situation_vi' => 'Em đi chợ mua trái cây.', 'situation_en' => 'You buy fruit at the market.',
                    'ai_role' => 'a fruit seller', 'student_role' => 'a customer',
                    'opening_line' => 'Hello! What would you like today?',
                ],
                [
                    'title_en' => 'Returning a shirt', 'title_vi' => 'Đổi áo',
                    'situation_vi' => 'Chiếc áo em mua bị chật.', 'situation_en' => 'The shirt you bought is too small.',
                    'ai_role' => 'a shop assistant', 'student_role' => 'a customer',
                    'opening_line' => 'Good morning. How can I help you?',
                ],
            ],
        ]);

        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => $payload]]]])]);
    }

    public function test_teacher_generates_a_draft_pack_for_a_unit(): void
    {
        $teacher = User::factory()->teacher()->create();
        $unit = $this->unit();
        $this->fakeGeneratedPack();

        Livewire::actingAs($teacher)
            ->test(Show::class, ['unit' => $unit])
            ->call('generate')
            ->assertDispatched('notify')
            ->assertSee('Shopping');

        $topic = Topic::firstOrFail();
        $this->assertSame($unit->id, $topic->curriculum_unit_id);
        $this->assertSame(TopicStatus::Draft, $topic->status, 'generated content must not reach students unreviewed');
        $this->assertSame('lop-8-unit-8-shopping', $topic->slug);
        $this->assertSame(10, $topic->sentencePatterns()->count());
        $this->assertSame(2, $topic->roleplayScenarios()->count());
        $this->assertDatabaseHas('roleplay_scenarios', ['title_en' => 'At the market', 'situation_en' => 'You buy fruit at the market.']);
    }

    public function test_the_prompt_states_the_grade_unit_and_level(): void
    {
        $teacher = User::factory()->teacher()->create();
        $unit = $this->unit();
        $this->fakeGeneratedPack();

        Livewire::actingAs($teacher)->test(Show::class, ['unit' => $unit])->call('generate');

        Http::assertSent(function (Request $request) {
            $messages = $request->data()['messages'];

            return str_contains($messages[0]['content'], 'Never reproduce text, exercises or reading')
                && str_contains($messages[1]['content'], 'Grade 8, Unit 8: "Shopping"')
                && str_contains($messages[1]['content'], 'CEFR A1-A2');
        });
    }

    public function test_generating_twice_creates_two_drafts_with_different_slugs(): void
    {
        $teacher = User::factory()->teacher()->create();
        $unit = $this->unit();
        $this->fakeGeneratedPack();

        Livewire::actingAs($teacher)
            ->test(Show::class, ['unit' => $unit])
            ->call('generate')
            ->call('generate');

        $this->assertSame(2, Topic::count());
        $this->assertSame(['lop-8-unit-8-shopping', 'lop-8-unit-8-shopping-2'], Topic::orderBy('id')->pluck('slug')->all());
    }

    public function test_a_short_or_unparseable_answer_stores_nothing(): void
    {
        $teacher = User::factory()->teacher()->create();
        $unit = $this->unit();
        Http::fake(['openrouter.ai/*' => Http::response(['choices' => [['message' => ['content' => '{"patterns": [{"english": "Hi", "vietnamese": "Chào"}], "scenarios": []}']]]])]);

        Livewire::actingAs($teacher)
            ->test(Show::class, ['unit' => $unit])
            ->call('generate')
            ->assertSee('Chưa soạn được nội dung');

        $this->assertDatabaseCount('topics', 0);
        $this->assertDatabaseCount('sentence_patterns', 0);
    }

    public function test_ai_failure_shows_a_message_and_stores_nothing(): void
    {
        $teacher = User::factory()->teacher()->create();
        $unit = $this->unit();
        Http::fake(['openrouter.ai/*' => Http::response(['error' => 'overloaded'], 503)]);

        Livewire::actingAs($teacher)
            ->test(Show::class, ['unit' => $unit])
            ->call('generate')
            ->assertSee('Chưa soạn được nội dung');

        $this->assertDatabaseCount('topics', 0);
    }

    public function test_student_cannot_generate_content(): void
    {
        Http::fake();
        $student = User::factory()->student()->create();
        $unit = $this->unit();

        Livewire::actingAs($student)
            ->test(Show::class, ['unit' => $unit])
            ->call('generate')
            ->assertForbidden();

        Http::assertNothingSent();
        $this->assertDatabaseCount('topics', 0);
    }
}
