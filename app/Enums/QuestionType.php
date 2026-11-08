<?php

namespace App\Enums;

enum QuestionType: string
{
    case MultipleChoice = 'multiple_choice';
    case TrueFalse = 'true_false';
    case GapFill = 'gap_fill';
    // "school / go / I / to" → "I go to school"
    case Reorder = 'reorder';
    // Rewrite a sentence as asked; several wordings may be accepted.
    case Rewrite = 'rewrite';
    // One pair per question; the options are the right-hand column, shared by the group.
    case Matching = 'matching';
    // Choose the word whose [marked] part is pronounced differently, or with different stress.
    case Pronunciation = 'pronunciation';

    public function label(): string
    {
        return __("skills.question.{$this->value}");
    }

    public function hasOptions(): bool
    {
        return in_array($this, [self::MultipleChoice, self::TrueFalse, self::Matching, self::Pronunciation], true);
    }

    public function acceptsAlternatives(): bool
    {
        return $this === self::Rewrite;
    }
}
