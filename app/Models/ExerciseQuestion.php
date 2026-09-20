<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ExerciseQuestion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['skill_exercise_id', 'type', 'prompt', 'options', 'answer', 'explanation_vi', 'sort_order'];

    protected function casts(): array
    {
        return [
            'type' => QuestionType::class,
            'options' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(SkillExercise::class, 'skill_exercise_id');
    }

    /**
     * Marking is deliberately forgiving: case, spacing and surrounding punctuation are ignored,
     * because the skill being tested is comprehension, not typing.
     */
    public function isCorrect(?string $given): bool
    {
        return self::normalise($given) === self::normalise($this->answer);
    }

    public static function normalise(?string $value): string
    {
        $value = Str::lower(trim((string) $value));
        $value = preg_replace('/[\p{P}\p{S}]/u', '', $value);

        return trim(preg_replace('/\s+/u', ' ', $value));
    }
}
