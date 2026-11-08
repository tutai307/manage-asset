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

    protected $fillable = [
        'skill_exercise_id', 'type', 'prompt', 'options', 'answer', 'accepted_answers', 'explanation_vi', 'needs_check', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'type' => QuestionType::class,
            'options' => 'array',
            'accepted_answers' => 'array',
            'needs_check' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * The words of a reorder question, as the student sees them: "school / go / I / to".
     *
     * @return list<string>
     */
    public function scrambledWords(): array
    {
        return array_values(array_filter(array_map('trim', explode('/', $this->prompt)), 'strlen'));
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
        $given = self::normalise($given);

        if ($given === '') {
            return false;
        }

        $accepted = [$this->answer, ...($this->type->acceptsAlternatives() ? ($this->accepted_answers ?? []) : [])];

        return collect($accepted)->contains(fn ($answer) => self::normalise($answer) === $given);
    }

    public static function normalise(?string $value): string
    {
        $value = Str::lower(trim((string) $value));
        $value = preg_replace('/[\p{P}\p{S}]/u', '', $value);

        return trim(preg_replace('/\s+/u', ' ', $value));
    }
}
