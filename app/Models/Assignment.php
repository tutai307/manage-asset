<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An exercise given to one class, optionally with a due date.
 */
class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['skill_exercise_id', 'classroom_id', 'assigned_by', 'due_at'];

    protected function casts(): array
    {
        return [
            'due_at' => 'datetime',
        ];
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(SkillExercise::class, 'skill_exercise_id');
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function isOverdue(): bool
    {
        return $this->due_at !== null && $this->due_at->isPast();
    }
}
