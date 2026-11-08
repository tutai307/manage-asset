<?php

namespace App\Http\Controllers;

use App\Models\SkillExercise;
use App\Services\Uploads\TestFileStore;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExerciseSourceController extends Controller
{
    /**
     * Show the uploaded test an exercise was read from — to whoever may edit the exercise only.
     */
    public function __invoke(SkillExercise $exercise, int $index): StreamedResponse
    {
        Gate::authorize('update', $exercise);

        $path = $exercise->source_files['files'][$index] ?? null;

        abort_unless(
            is_string($path) && str_starts_with($path, TestFileStore::DIRECTORY.'/') && Storage::disk('local')->exists($path),
            404,
        );

        return Storage::disk('local')->response($path, headers: [
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
