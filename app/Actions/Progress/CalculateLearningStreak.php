<?php

namespace App\Actions\Progress;

use App\Enums\MessageRole;
use App\Models\ConversationMessage;
use App\Models\PatternReveal;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class CalculateLearningStreak
{
    /**
     * Number of consecutive days, ending today or yesterday, on which the student practised
     * (sent a role-play message or revealed a sentence meaning).
     */
    public function handle(User $student, ?CarbonImmutable $today = null): int
    {
        $timezone = config('app.display_timezone');
        $today = ($today ?? CarbonImmutable::now($timezone))->startOfDay();
        $since = $today->subDays(60);

        $activeDays = $this->activeDays($student, $since, $timezone);

        return self::countStreak($activeDays, $today);
    }

    /**
     * @param  Collection<int, string>  $activeDays  Y-m-d dates
     */
    public static function countStreak(Collection $activeDays, CarbonImmutable $today): int
    {
        $days = $activeDays->flip();
        $cursor = $days->has($today->toDateString()) ? $today : $today->subDay();
        $streak = 0;

        while ($days->has($cursor->toDateString())) {
            $streak++;
            $cursor = $cursor->subDay();
        }

        return $streak;
    }

    /**
     * @return Collection<int, string>
     */
    private function activeDays(User $student, CarbonImmutable $since, string $timezone): Collection
    {
        $messageTimes = ConversationMessage::query()
            ->where('role', MessageRole::Student->value)
            ->where('created_at', '>=', $since->utc())
            ->whereHas('conversation', fn ($query) => $query->where('user_id', $student->id))
            ->pluck('created_at');

        $revealTimes = PatternReveal::query()
            ->where('user_id', $student->id)
            ->where('created_at', '>=', $since->utc())
            ->pluck('created_at');

        return $messageTimes->concat($revealTimes)
            ->map(fn ($time) => $time->copy()->setTimezone($timezone)->toDateString())
            ->unique()
            ->values();
    }
}
