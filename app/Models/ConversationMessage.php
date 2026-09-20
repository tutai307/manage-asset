<?php

namespace App\Models;

use App\Enums\MessageRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Append-only: never updated or deleted.
 */
class ConversationMessage extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = ['conversation_id', 'role', 'content'];

    protected function casts(): array
    {
        return [
            'role' => MessageRole::class,
            'created_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}
