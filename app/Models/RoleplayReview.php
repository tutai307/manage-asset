<?php

namespace App\Models;

use App\Enums\AppLocale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Append-only: never updated or deleted.
 */
class RoleplayReview extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = ['conversation_id', 'model', 'good_count', 'reviewed_count', 'summary_vi', 'summary_en'];

    protected function casts(): array
    {
        return [
            'good_count' => 'integer',
            'reviewed_count' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(RoleplayReviewItem::class)->orderBy('sort_order')->orderBy('id');
    }

    public function summary(): string
    {
        return AppLocale::current() === AppLocale::English ? $this->summary_en : $this->summary_vi;
    }
}
