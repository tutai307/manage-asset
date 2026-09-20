<?php

namespace App\Models;

use App\Enums\MessageRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    /**
     * Maximum number of student messages in one role-play session.
     */
    public const MAX_STUDENT_TURNS = 12;

    protected $fillable = ['user_id', 'roleplay_scenario_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scenario(): BelongsTo
    {
        return $this->belongsTo(RoleplayScenario::class, 'roleplay_scenario_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ConversationMessage::class)->orderBy('id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(RoleplayReview::class);
    }

    public function latestReview(): ?RoleplayReview
    {
        return $this->reviews()->with('items')->latest('id')->first();
    }

    public function studentTurnCount(): int
    {
        return $this->messages()->where('role', MessageRole::Student->value)->count();
    }

    public function hasReachedTurnLimit(): bool
    {
        return $this->studentTurnCount() >= self::MAX_STUDENT_TURNS;
    }
}
