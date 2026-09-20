<?php

namespace Tests\Unit\Progress;

use App\Actions\Progress\CalculateLearningStreak;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class CalculateLearningStreakTest extends TestCase
{
    private CarbonImmutable $today;

    protected function setUp(): void
    {
        parent::setUp();

        $this->today = CarbonImmutable::parse('2026-09-20');
    }

    public function test_no_activity_means_no_streak(): void
    {
        $this->assertSame(0, CalculateLearningStreak::countStreak(new Collection, $this->today));
    }

    public function test_consecutive_days_ending_today_are_counted(): void
    {
        $days = new Collection(['2026-09-20', '2026-09-19', '2026-09-18']);

        $this->assertSame(3, CalculateLearningStreak::countStreak($days, $this->today));
    }

    public function test_streak_still_counts_when_today_has_no_activity_yet(): void
    {
        $days = new Collection(['2026-09-19', '2026-09-18']);

        $this->assertSame(2, CalculateLearningStreak::countStreak($days, $this->today));
    }

    public function test_a_gap_ends_the_streak(): void
    {
        $days = new Collection(['2026-09-20', '2026-09-18', '2026-09-17']);

        $this->assertSame(1, CalculateLearningStreak::countStreak($days, $this->today));
    }

    public function test_activity_older_than_yesterday_only_is_not_a_streak(): void
    {
        $days = new Collection(['2026-09-15', '2026-09-14']);

        $this->assertSame(0, CalculateLearningStreak::countStreak($days, $this->today));
    }
}
