<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Teacher = 'teacher';
    case Student = 'student';

    public function label(): string
    {
        return __("common.roles.{$this->value}");
    }

    public function canTeach(): bool
    {
        return in_array($this, [self::Admin, self::Teacher], true);
    }

    public function seesEverything(): bool
    {
        return $this === self::Admin;
    }
}
