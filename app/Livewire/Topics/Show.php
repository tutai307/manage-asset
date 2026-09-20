<?php

namespace App\Livewire\Topics;

use App\Actions\Roleplay\StartRoleplay;
use App\Enums\SupportLevel;
use App\Models\PatternReveal;
use App\Models\Topic;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Show extends Component
{
    #[Locked]
    public int $topicId;

    public SupportLevel $supportLevel = SupportLevel::Full;

    /**
     * Pattern IDs whose Vietnamese meaning was revealed during this visit.
     *
     * @var list<int>
     */
    public array $revealed = [];

    public function mount(Topic $topic): void
    {
        Gate::authorize('view', $topic);

        $this->topicId = $topic->id;
    }

    public function setSupportLevel(string $level): void
    {
        $this->supportLevel = SupportLevel::from($level);
        $this->revealed = [];
    }

    public function reveal(int $patternId): void
    {
        $topic = $this->topic();
        Gate::authorize('view', $topic);

        $pattern = $topic->sentencePatterns()->findOrFail($patternId);

        if (in_array($pattern->id, $this->revealed, true)) {
            return;
        }

        PatternReveal::create(['user_id' => auth()->id(), 'sentence_pattern_id' => $pattern->id]);

        $this->revealed[] = $pattern->id;
    }

    public function startRoleplay(int $scenarioId, StartRoleplay $startRoleplay): void
    {
        $topic = $this->topic();
        Gate::authorize('view', $topic);

        $scenario = $topic->roleplayScenarios()->findOrFail($scenarioId);
        $conversation = $startRoleplay->handle(auth()->user(), $scenario);

        $this->redirectRoute('conversations.show', $conversation);
    }

    public function render()
    {
        $topic = $this->topic()->load(['sentencePatterns', 'roleplayScenarios']);

        return view('livewire.topics.show', [
            'topic' => $topic,
            'levels' => SupportLevel::cases(),
        ])->title($topic->title());
    }

    private function topic(): Topic
    {
        return Topic::query()->findOrFail($this->topicId);
    }
}
