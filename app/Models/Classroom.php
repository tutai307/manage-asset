<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['teacher_id', 'name', 'grade'];

    protected function casts(): array
    {
        return [
            'grade' => 'integer',
        ];
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->where('users.role', UserRole::Student->value)
            ->withTimestamps();
    }

    /**
     * Limit to the classes a user may see: all for an administrator, their own for a teacher.
     */
    public function scopeVisibleTo(Builder $query, User $user): void
    {
        if (! $user->role->seesEverything()) {
            $query->where('teacher_id', $user->id);
        }
    }
}
