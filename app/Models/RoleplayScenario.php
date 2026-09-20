<?php

namespace App\Models;

use App\Enums\AppLocale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleplayScenario extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id', 'title_en', 'title_vi', 'situation_vi', 'situation_en', 'ai_role', 'student_role', 'opening_line', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * Title in the interface language.
     */
    public function title(): string
    {
        return AppLocale::current() === AppLocale::Vietnamese ? $this->title_vi : $this->title_en;
    }

    /**
     * Situation in the interface language, falling back to Vietnamese when no English exists.
     */
    public function situation(): string
    {
        return AppLocale::current() === AppLocale::English
            ? ($this->situation_en ?? $this->situation_vi)
            : $this->situation_vi;
    }
}
