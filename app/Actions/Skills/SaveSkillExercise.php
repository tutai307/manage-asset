<?php

namespace App\Actions\Skills;

use App\Enums\QuestionType;
use App\Models\SkillExercise;
use Illuminate\Support\Facades\DB;

class SaveSkillExercise
{
    /**
     * Apply a teacher's edits to an exercise and its questions.
     *
     * Questions are matched by id: those left out are removed, the rest are updated or created,
     * and the order on screen becomes the order students see.
     *
     * @param  array<string, mixed>  $attributes
     * @param  list<array{id: ?int, type: string, prompt: string, options: ?array<int, string>, answer: string, explanation_vi: ?string}>  $questions
     */
    public function handle(SkillExercise $exercise, array $attributes, array $questions): SkillExercise
    {
        return DB::transaction(function () use ($exercise, $attributes, $questions) {
            $exercise->update($attributes);

            $keptIds = [];

            foreach (array_values($questions) as $index => $question) {
                $payload = [
                    'type' => QuestionType::from($question['type']),
                    'prompt' => $question['prompt'],
                    'options' => $question['options'],
                    'answer' => $question['answer'],
                    'explanation_vi' => $question['explanation_vi'],
                    'sort_order' => $index + 1,
                ];

                $row = $question['id']
                    ? tap($exercise->questions()->findOrFail($question['id']))->update($payload)
                    : $exercise->questions()->create($payload);

                $keptIds[] = $row->id;
            }

            $exercise->questions()->whereNotIn('id', $keptIds ?: [0])->delete();

            return $exercise->fresh('questions');
        });
    }
}
