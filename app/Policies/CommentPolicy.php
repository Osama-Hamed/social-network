<?php

namespace App\Policies;

use App\User;
use App\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Comment $comment)
    {
        return $user->is($comment->owner);
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->is($comment->owner) || $user->is($comment->post->owner);
    }
}
