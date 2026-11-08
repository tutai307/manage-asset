<?php

namespace App\Enums;

/**
 * Where an exercise came from. Only generated exercises belong to a unit's open practice;
 * a teacher's manual or uploaded exercise is theirs and reaches students by assignment.
 */
enum ExerciseSource: string
{
    case Generated = 'generated';
    case Manual = 'manual';
    case Upload = 'upload';

    public function label(): string
    {
        return __("skills.source.{$this->value}");
    }
}
