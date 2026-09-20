<?php

namespace App\Models;

use App\Enums\AppLocale;
use App\Enums\TopicStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['curriculum_unit_id', 'slug', 'emoji', 'title_en', 'title_vi', 'description_vi', 'description_en', 'status', 'sort_order'];

    protected function casts(): array
    {
        return [
            'status' => TopicStatus::class,
            'sort_order' => 'integer',
        ];
    }

    /**
     * Title in the interface language.
     */
    public function title(): string
    {
        return AppLocale::current() === AppLocale::Vietnamese ? $this->title_vi : $this->title_en;
    }

    /**
     * Description in the interface language, falling back to Vietnamese when no English exists.
     */
    public function description(): ?string
    {
        return AppLocale::current() === AppLocale::English
            ? ($this->description_en ?? $this->description_vi)
            : $this->description_vi;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(CurriculumUnit::class, 'curriculum_unit_id');
    }

    public function sentencePatterns(): HasMany
    {
        return $this->hasMany(SentencePattern::class)->orderBy('sort_order')->orderBy('id');
    }

    public function roleplayScenarios(): HasMany
    {
        return $this->hasMany(RoleplayScenario::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Topics in which the student has started at least one role-play.
     */
    public function scopePractisedBy(Builder $query, User $student): void
    {
        $query->whereHas('roleplayScenarios.conversations', fn (Builder $q) => $q->where('user_id', $student->id));
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', TopicStatus::Published->value);
    }

    public function scopeVisibleTo(Builder $query, User $user): void
    {
        if (! $user->role->canTeach()) {
            $query->published();
        }
    }
}
