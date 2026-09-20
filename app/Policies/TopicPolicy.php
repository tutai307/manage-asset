<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TopicPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Students must not learn that an unpublished topic exists, so they get a 404.
     */
    public function view(User $user, Topic $topic): Response
    {
        if ($user->role->canTeach() || $topic->status->isVisibleToStudents()) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }

    public function create(User $user): bool
    {
        return $user->role->canTeach();
    }

    public function update(User $user, Topic $topic): bool
    {
        return $user->role->canTeach();
    }

    public function delete(User $user, Topic $topic): bool
    {
        return $user->role->canTeach();
    }
}
