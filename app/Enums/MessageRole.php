<?php

namespace App\Enums;

enum MessageRole: string
{
    case Assistant = 'assistant';
    case Student = 'student';

    /**
     * The role name expected by OpenAI-compatible chat APIs.
     */
    public function apiRole(): string
    {
        return match ($this) {
            self::Assistant => 'assistant',
            self::Student => 'user',
        };
    }
}
