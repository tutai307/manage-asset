<?php

namespace App\Enums;

/**
 * Interface languages the user can switch between.
 */
enum AppLocale: string
{
    case Vietnamese = 'vi';
    case English = 'en';

    public function label(): string
    {
        return match ($this) {
            self::Vietnamese => 'Tiếng Việt',
            self::English => 'English',
        };
    }

    public function shortLabel(): string
    {
        return strtoupper($this->value);
    }

    public static function current(): self
    {
        return self::tryFrom(app()->getLocale()) ?? self::Vietnamese;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
