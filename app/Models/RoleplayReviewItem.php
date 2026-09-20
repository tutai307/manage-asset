<?php

namespace App\Models;

use App\Enums\AppLocale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleplayReviewItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'roleplay_review_id', 'conversation_message_id', 'original', 'is_good',
        'better_en', 'note_vi', 'note_en', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_good' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(RoleplayReview::class, 'roleplay_review_id');
    }

    public function note(): ?string
    {
        return AppLocale::current() === AppLocale::English
            ? ($this->note_en ?? $this->note_vi)
            : ($this->note_vi ?? $this->note_en);
    }
}
