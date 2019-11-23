<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function show(User $user)
    {
    	return response()->json([
    		'profileUser' => $user,
    		'profilePosts' => $user->posts()->latest()->get(),
            'profileFriends' => $user->allFriends(),
            'friendship' => [
                'isEstablished' => auth()->user()->isFriendOf($user),
                'isRecieved' => auth()->user()->hasFriendRequestFrom($user),
                'isSent' => auth()->user()->sentFriendRequestTo($user)
            ]
    	], 200);
    }

    public function update(UpdateProfileRequest $form, User $user)
    {
        return response()->json($form->save(), 200);
    }
}
