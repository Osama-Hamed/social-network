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
            'ip' => geoip()
    	], 200);
    }

    public function update(UpdateProfileRequest $form, User $user)
    {
        return response()->json($form->save(), 200);
    }
}
