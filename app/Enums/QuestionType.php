<?php

namespace App\Enums;

enum QuestionType: string
{
    case MultipleChoice = 'multiple_choice';
    case TrueFalse = 'true_false';
    case GapFill = 'gap_fill';

    public function label(): string
    {
        return __("skills.question.{$this->value}");
    }

    public function hasOptions(): bool
    {
        return in_array($this, [self::MultipleChoice, self::TrueFalse], true);
    }
}
