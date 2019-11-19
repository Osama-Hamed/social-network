<?php

namespace App\Http\Controllers;

use App\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
    	return response()->json([
    		'profileUser' => $user,
    		'profilePosts' => $user->posts()->latest()->get(),
            'ip' => geoip()
    	], 200);
    }

    public function update(User $user)
    {
    	$this->authorize('update', $user);

        $user->update(request()->validate(['bio' => 'nullable|string|max:101']));

        return response()->json($user, 200);
    }
}
