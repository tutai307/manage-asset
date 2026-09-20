<?php

namespace App\Livewire\Topics;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        $term = trim($this->search);

        $topics = Topic::query()
            ->visibleTo($user)
            ->when($term !== '', fn (Builder $query) => $query->where(fn (Builder $q) => $q
                ->where('title_en', 'like', "%{$term}%")
                ->orWhere('title_vi', 'like', "%{$term}%")))
            ->withCount([
                'sentencePatterns',
                'roleplayScenarios',
                'roleplayScenarios as practised_scenarios_count' => fn (Builder $q) => $q
                    ->whereHas('conversations', fn (Builder $c) => $c->where('user_id', $user->id)),
            ])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(24);

        return view('livewire.topics.index', ['topics' => $topics])->title(__('topics.title'));
    }
}
