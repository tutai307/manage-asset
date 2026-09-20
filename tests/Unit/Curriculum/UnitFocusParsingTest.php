<?php

namespace Tests\Unit\Curriculum;

use App\Actions\Curriculum\SaveUnitFocus;
use App\Models\ExerciseQuestion;
use PHPUnit\Framework\TestCase;

class UnitFocusParsingTest extends TestCase
{
    private SaveUnitFocus $action;

    protected function setUp(): void
    {
        parent::setUp();

        $this->action = new SaveUnitFocus;
    }

    public function test_it_reads_word_part_of_speech_and_meaning(): void
    {
        $parsed = $this->action->parse('shop assistant (n) = nhân viên bán hàng');

        $this->assertSame([['word' => 'shop assistant', 'part_of_speech' => 'n', 'meaning_vi' => 'nhân viên bán hàng']], $parsed);
    }

    public function test_it_accepts_the_separators_teachers_actually_type(): void
    {
        $parsed = $this->action->parse("discount = giảm giá\ntry on : mặc thử\nsize — cỡ");

        $this->assertSame(['discount', 'try on', 'size'], array_column($parsed, 'word'));
        $this->assertSame(['giảm giá', 'mặc thử', 'cỡ'], array_column($parsed, 'meaning_vi'));
    }

    public function test_it_skips_blank_and_malformed_lines(): void
    {
        $parsed = $this->action->parse("\n\ndiscount = giảm giá\njust a heading\n   \n");

        $this->assertCount(1, $parsed);
    }

    public function test_it_keeps_the_first_of_two_identical_words(): void
    {
        $parsed = $this->action->parse("discount = giảm giá\nDiscount = sự giảm giá");

        $this->assertCount(1, $parsed);
        $this->assertSame('giảm giá', $parsed[0]['meaning_vi']);
    }

    public function test_marking_ignores_case_spacing_and_punctuation(): void
    {
        $this->assertSame('on sunday', ExerciseQuestion::normalise('  On   Sunday. '));
        $this->assertSame('a blue shirt', ExerciseQuestion::normalise('A blue shirt!'));
        $this->assertSame('', ExerciseQuestion::normalise(null));
    }
}
