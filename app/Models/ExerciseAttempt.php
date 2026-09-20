<?php

namespace App\Models;

use App\Enums\AppLocale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Append-only: never updated or deleted.
 */
class ExerciseAttempt extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id', 'skill_exercise_id', 'score', 'max_score', 'answers',
        'written_answer', 'feedback_vi', 'feedback_en',
    ];

    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'score' => 'integer',
            'max_score' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(SkillExercise::class, 'skill_exercise_id');
    }

    public function feedback(): ?string
    {
        return AppLocale::current() === AppLocale::English
            ? ($this->feedback_en ?? $this->feedback_vi)
            : ($this->feedback_vi ?? $this->feedback_en);
    }

    public function percentage(): int
    {
        return $this->max_score > 0 ? (int) round($this->score / $this->max_score * 100) : 0;
    }
}
