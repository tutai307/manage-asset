<?php

namespace App\Livewire;

use App\Actions\Progress\CalculateLearningStreak;
use App\Enums\MessageRole;
use App\Models\Classroom;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\PatternReveal;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(CalculateLearningStreak $calculateStreak)
    {
        $user = auth()->user();

        if ($user->can('viewAny', Classroom::class)) {
            return view('livewire.dashboard.teacher', $this->teacherData($user))
                ->title(__('nav.dashboard'));
        }

        return view('livewire.dashboard.student', $this->studentData($user, $calculateStreak))
            ->title(__('nav.dashboard'));
    }

    private function studentData(User $student, CalculateLearningStreak $calculateStreak): array
    {
        $studentTurns = fn ($query) => $query->where('role', MessageRole::Student->value);

        return [
            'streak' => $calculateStreak->handle($student),
            'stats' => [
                'roleplays' => $student->conversations()->count(),
                'messages' => ConversationMessage::query()
                    ->where('role', MessageRole::Student->value)
                    ->whereHas('conversation', fn ($q) => $q->where('user_id', $student->id))
                    ->count(),
                'topics' => Topic::query()->published()->practisedBy($student)->count(),
                'reveals' => PatternReveal::query()->where('user_id', $student->id)->count(),
            ],
            'totalTopics' => Topic::query()->published()->count(),
            'recentConversations' => $student->conversations()
                ->with('scenario.topic')
                ->withCount(['messages as student_turns' => $studentTurns])
                ->latest('updated_at')
                ->limit(3)
                ->get(),
            'suggestedTopics' => Topic::query()
                ->published()
                ->whereDoesntHave('roleplayScenarios.conversations', fn ($q) => $q->where('user_id', $student->id))
                ->withCount('sentencePatterns')
                ->orderBy('sort_order')
                ->limit(3)
                ->get(),
        ];
    }

    private function teacherData(User $teacher): array
    {
        $classroomIds = Classroom::query()->visibleTo($teacher)->select('id');
        $studentIds = DB::table('classroom_user')->whereIn('classroom_id', $classroomIds)->select('user_id');
        $weekAgo = now()->subDays(7);

        return [
            'stats' => [
                'classes' => Classroom::query()->visibleTo($teacher)->count(),
                'students' => DB::table('classroom_user')->whereIn('classroom_id', $classroomIds)->distinct()->count('user_id'),
                'roleplays_week' => Conversation::query()->whereIn('user_id', $studentIds)->where('created_at', '>=', $weekAgo)->count(),
                'active_week' => Conversation::query()->whereIn('user_id', $studentIds)->where('updated_at', '>=', $weekAgo)->distinct()->count('user_id'),
            ],
            'classrooms' => Classroom::query()
                ->visibleTo($teacher)
                ->withCount('students')
                ->orderBy('name')
                ->limit(6)
                ->get(),
            'recentActivity' => Conversation::query()
                ->whereIn('user_id', $studentIds)
                ->with(['user', 'scenario.topic'])
                ->withCount(['messages as student_turns' => fn ($q) => $q->where('role', MessageRole::Student->value)])
                ->latest('updated_at')
                ->limit(8)
                ->get(),
            'publishedTopics' => Topic::query()->published()->count(),
        ];
    }
}
