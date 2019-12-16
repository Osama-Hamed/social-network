<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $auth_user = auth()->user();

    	return response()->json([
    		'owner' => $user,
    		'posts' => $user->profilePosts(),
            'friends' => $user->allFriends(),
            'friendship' => [
                'isEstablished' => $auth_user->isFriendOf($user),
                'isRecieved' => $auth_user->hasFriendRequestFrom($user),
                'isSent' => $auth_user->sentFriendRequestTo($user)
            ]
    	], 200);
    }

    public function update(UpdateProfileRequest $form, User $user)
    {
        return response()->json($form->save(), 200);
    }
}
