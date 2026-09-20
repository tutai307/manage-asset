<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitVocabulary extends Model
{
    use HasFactory;

    protected $table = 'unit_vocabulary';

    protected $fillable = ['curriculum_unit_id', 'word', 'part_of_speech', 'meaning_vi', 'sort_order'];

    protected function casts(): array
    {
        return ['sort_order' => 'integer'];
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(CurriculumUnit::class, 'curriculum_unit_id');
    }
}
