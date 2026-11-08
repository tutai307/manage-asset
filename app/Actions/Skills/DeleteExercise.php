<?php

namespace App\Actions\Skills;

use App\Exceptions\StillInUseException;
use App\Models\SkillExercise;
use App\Services\Uploads\TestFileStore;
use Illuminate\Support\Facades\DB;

class DeleteExercise
{
    public function __construct(private readonly TestFileStore $files) {}

    /**
     * Delete an exercise nobody has handed in yet, with its questions, assignments and original
     * files. Once a student has an attempt, removing the assignment is the way to stop it.
     *
     * @throws StillInUseException
     */
    public function handle(SkillExercise $exercise): void
    {
        if ($exercise->attempts()->exists()) {
            throw new StillInUseException('skills.delete_in_use');
        }

        $paths = $exercise->source_files['files'] ?? [];

        DB::transaction(fn () => $exercise->delete());

        $this->files->delete($paths);
    }
}
