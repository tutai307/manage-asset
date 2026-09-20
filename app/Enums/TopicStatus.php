<?php

namespace App\Enums;

enum TopicStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    public function label(): string
    {
        return __("topics.status.{$this->value}");
    }

    public function isVisibleToStudents(): bool
    {
        return $this === self::Published;
    }
}
