<?php

namespace App\Models;

use App\Enums\AppLocale;
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
        'curriculum_unit_id', 'skill', 'title_en', 'title_vi', 'instructions_vi', 'instructions_en',
        'passage', 'prompt_vi', 'prompt_en', 'min_words', 'status', 'model', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'skill' => SkillType::class,
            'status' => TopicStatus::class,
            'min_words' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(CurriculumUnit::class, 'curriculum_unit_id');
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

    public function scopeVisibleTo(Builder $query, User $user): void
    {
        if (! $user->role->canTeach()) {
            $query->where('status', TopicStatus::Published->value);
        }
    }
}
