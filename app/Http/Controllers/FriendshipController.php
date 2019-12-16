<?php

namespace App\Http\Controllers;

use App\User;

class FriendshipController extends Controller
{
    public function store()
    {
        $user = User::where('username', request('username'))->firstOrFail();
        
    	auth()->user()->sendFriendRequest($user);

        return response()->json('Friend request sent successfully', 200);
    }

    public function update(User $user)
    {
    	auth()->user()->addFriend($user);

        return response()->json('Friendship started successfully', 200);
    }

    public function destroy(User $user)
    {
        $auth_user = auth()->user();

        if ($auth_user->isFriendOf($user)) {
            $auth_user->unfriend($user);
            return response()->json('Friendship ended successfully', 200);
        }

        $auth_user->cancelFriendRequest($user);
        return response()->json('Friend request canceled successfully', 200);
    }
}
