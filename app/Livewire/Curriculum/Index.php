<?php

namespace App\Livewire\Curriculum;

use App\Enums\TopicStatus;
use App\Models\CurriculumUnit;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;

class Index extends Component
{
    /** Grade being viewed. Students are locked to their own class's grade. */
    #[Url(except: '')]
    public string $grade = '';

    public function mount(): void
    {
        $own = auth()->user()->currentGrade();

        if ($own !== null && ! auth()->user()->role->canTeach()) {
            $this->grade = (string) $own;
        }

        if ($this->grade === '') {
            $this->grade = (string) ($own ?? CurriculumUnit::GRADES[0]);
        }
    }

    public function setGrade(int $grade): void
    {
        if (auth()->user()->role->canTeach() && in_array($grade, CurriculumUnit::GRADES, true)) {
            $this->grade = (string) $grade;
        }
    }

    public function render()
    {
        $user = auth()->user();
        $publishedOnly = ! $user->role->canTeach();

        $units = CurriculumUnit::query()
            ->forGrade((int) $this->grade)
            ->withCount([
                'topics as published_topics_count' => fn (Builder $q) => $q->where('status', TopicStatus::Published->value),
                'topics as draft_topics_count' => fn (Builder $q) => $q->where('status', TopicStatus::Draft->value),
            ])
            ->inOrder()
            ->get();

        return view('livewire.curriculum.index', [
            'units' => $units->groupBy('term'),
            'grades' => CurriculumUnit::GRADES,
            'canChooseGrade' => $user->role->canTeach(),
            'publishedOnly' => $publishedOnly,
        ])->title(__('curriculum.title'));
    }
}
