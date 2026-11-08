<?php

namespace App\Actions\Curriculum;

use App\Exceptions\StillInUseException;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

class DeleteTopic
{
    /**
     * Delete a speaking lesson no student has practised, with its sentences and situations.
     *
     * @throws StillInUseException
     */
    public function handle(Topic $topic): void
    {
        if ($topic->roleplayScenarios()->whereHas('conversations')->exists()) {
            throw new StillInUseException('curriculum.delete_in_use');
        }

        DB::transaction(fn () => $topic->delete());
    }
}
