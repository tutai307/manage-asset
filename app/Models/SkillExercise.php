<?php

namespace App\Models;

use App\Enums\AppLocale;
use App\Enums\ExerciseSource;
use App\Enums\SkillType;
use App\Enums\TopicStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_unit_id', 'owner_id', 'source', 'grade', 'skill', 'title_en', 'title_vi', 'instructions_vi',
        'instructions_en', 'passage', 'prompt_vi', 'prompt_en', 'min_words', 'status', 'model', 'source_files', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'skill' => SkillType::class,
            'status' => TopicStatus::class,
            'source' => ExerciseSource::class,
            'grade' => 'integer',
            'min_words' => 'integer',
            'sort_order' => 'integer',
            'source_files' => 'array',
        ];
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(CurriculumUnit::class, 'curriculum_unit_id');
    }

    /**
     * The teacher who wrote or uploaded this exercise; null for shipped and unit practice.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function isTeacherOwned(): bool
    {
        return $this->owner_id !== null;
    }

    /**
     * The grade it is meant for: the unit's, or the one the teacher chose for a test without a unit.
     */
    public function gradeLevel(): ?int
    {
        return $this->unit?->grade ?? $this->grade;
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ExerciseQuestion::class)->orderBy('sort_order')->orderBy('id');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(ExerciseAttempt::class);
    }

    public function title(): string
    {
        return AppLocale::current() === AppLocale::Vietnamese ? $this->title_vi : $this->title_en;
    }

    public function instructions(): string
    {
        return AppLocale::current() === AppLocale::Vietnamese ? $this->instructions_vi : $this->instructions_en;
    }

    public function prompt(): ?string
    {
        return AppLocale::current() === AppLocale::Vietnamese ? $this->prompt_vi : ($this->prompt_en ?? $this->prompt_vi);
    }

    /**
     * Teachers see the open unit practice and their own exercises (an administrator sees all).
     * Students see published open practice, and teacher-owned exercises assigned to their class.
     */
    public function scopeVisibleTo(Builder $query, User $user): void
    {
        if ($user->role->seesEverything()) {
            return;
        }

        if ($user->role->canTeach()) {
            $query->where(fn (Builder $q) => $q->whereNull('owner_id')->orWhere('owner_id', $user->id));

            return;
        }

        $query->where(function (Builder $q) use ($user) {
            $q->where(fn (Builder $open) => $open->whereNull('owner_id')->where('status', TopicStatus::Published->value))
                ->orWhereHas('assignments', fn (Builder $a) => $a->whereIn('classroom_id', $user->classrooms()->select('classrooms.id')));
        });
    }
}
