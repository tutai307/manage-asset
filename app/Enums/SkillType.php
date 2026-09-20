<?php

namespace App\Enums;

enum SkillType: string
{
    case Listening = 'listening';
    case Speaking = 'speaking';
    case Reading = 'reading';
    case Writing = 'writing';

    public function label(): string
    {
        return __("skills.type.{$this->value}");
    }

    public function icon(): string
    {
        return match ($this) {
            self::Listening => 'speaker',
            self::Speaking => 'microphone',
            self::Reading => 'book',
            self::Writing => 'pencil',
        };
    }

    /**
     * Listening and reading are built on a passage; writing is one open task; speaking is the role-play.
     */
    public function usesPassage(): bool
    {
        return in_array($this, [self::Listening, self::Reading], true);
    }

    public function isMarkedByAi(): bool
    {
        return $this === self::Writing;
    }
}
