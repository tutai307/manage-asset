<?php

namespace App\Models;

use App\Enums\AppLocale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * One unit of the Tiếng Anh 6–9 (Global Success) syllabus.
 */
class CurriculumUnit extends Model
{
    use HasFactory;

    public const GRADES = [6, 7, 8, 9];

    public const UNITS_PER_GRADE = 12;

    protected $fillable = [
        'grade', 'number', 'term', 'emoji', 'title_en', 'title_vi',
        'focus_vi', 'focus_en', 'grammar_en', 'grammar_vi', 'focus_approved',
    ];

    protected function casts(): array
    {
        return [
            'grade' => 'integer',
            'number' => 'integer',
            'term' => 'integer',
            'focus_approved' => 'boolean',
        ];
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    public function vocabulary(): HasMany
    {
        return $this->hasMany(UnitVocabulary::class)->orderBy('sort_order')->orderBy('id');
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(SkillExercise::class)->orderBy('sort_order')->orderBy('id');
    }

    public function grammar(): ?string
    {
        return AppLocale::current() === AppLocale::Vietnamese
            ? ($this->grammar_vi ?? $this->grammar_en)
            : ($this->grammar_en ?? $this->grammar_vi);
    }

    /**
     * Exercises may only be generated once the teacher has confirmed what the unit teaches,
     * otherwise "aligned to the book" would be a guess.
     */
    public function hasApprovedFocus(): bool
    {
        return $this->focus_approved && $this->vocabulary()->exists();
    }

    public function title(): string
    {
        return AppLocale::current() === AppLocale::Vietnamese ? $this->title_vi : $this->title_en;
    }

    public function focus(): ?string
    {
        return AppLocale::current() === AppLocale::English
            ? ($this->focus_en ?? $this->focus_vi)
            : $this->focus_vi;
    }

    public function label(): string
    {
        return __('curriculum.unit_number', ['number' => $this->number]);
    }

    public function scopeForGrade(Builder $query, ?int $grade): void
    {
        if ($grade !== null) {
            $query->where('grade', $grade);
        }
    }

    public function scopeInOrder(Builder $query): void
    {
        $query->orderBy('grade')->orderBy('number');
    }
}
