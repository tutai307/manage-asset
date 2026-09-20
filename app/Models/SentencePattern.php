<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SentencePattern extends Model
{
    use HasFactory;

    protected $fillable = ['topic_id', 'english', 'vietnamese', 'note_vi', 'sort_order'];

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

    public function reveals(): HasMany
    {
        return $this->hasMany(PatternReveal::class);
    }
}
