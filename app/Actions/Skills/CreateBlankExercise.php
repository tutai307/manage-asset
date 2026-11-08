<?php

namespace App\Actions\Skills;

use App\Enums\ExerciseSource;
use App\Enums\SkillType;
use App\Enums\TopicStatus;
use App\Models\CurriculumUnit;
use App\Models\SkillExercise;
use App\Models\User;

class CreateBlankExercise
{
    /**
     * An empty draft the teacher owns and fills in themselves. Its titles are placeholders the
     * editor asks them to replace.
     */
    public function handle(User $teacher, SkillType $skill, ?CurriculumUnit $unit, ?int $grade): SkillExercise
    {
        return SkillExercise::create([
            'curriculum_unit_id' => $unit?->id,
            'owner_id' => $teacher->id,
            'source' => ExerciseSource::Manual,
            'grade' => $unit ? null : $grade,
            'skill' => $skill,
            'title_en' => 'New exercise',
            'title_vi' => 'Bài tập mới',
            'instructions_en' => 'Answer the questions below.',
            'instructions_vi' => 'Làm các câu dưới đây.',
            'prompt_en' => $skill === SkillType::Writing ? 'Write about…' : null,
            'prompt_vi' => $skill === SkillType::Writing ? 'Viết về…' : null,
            'min_words' => $skill === SkillType::Writing ? 50 : null,
            'status' => TopicStatus::Draft,
        ]);
    }
}
