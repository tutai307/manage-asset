<?php

namespace App\Livewire\Roleplay;

use App\Enums\MessageRole;
use Livewire\Component;
use Livewire\WithPagination;

class History extends Component
{
    use WithPagination;

    public function render()
    {
        $conversations = auth()->user()->conversations()
            ->with('scenario.topic')
            ->withCount(['messages as student_turns' => fn ($q) => $q->where('role', MessageRole::Student->value)])
            ->latest('updated_at')
            ->paginate(15);

        return view('livewire.roleplay.history', ['conversations' => $conversations])
            ->title(__('nav.conversations'));
    }
}
