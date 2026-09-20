<?php

namespace App\Enums;

/**
 * How much Vietnamese support a student sees while studying sentence patterns.
 */
enum SupportLevel: string
{
    case Full = 'full';
    case Partial = 'partial';
    case EnglishOnly = 'english';

    public function label(): string
    {
        return __("topics.support.{$this->value}");
    }
}
