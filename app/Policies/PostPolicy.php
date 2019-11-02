<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function manage(User $user, Post $post)
    {
        return $user->is($post->owner);
    }
}
