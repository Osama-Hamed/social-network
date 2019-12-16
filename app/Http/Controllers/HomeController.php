<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $auth_user = auth()->user();

        return response()->json([
            'friendsActivities' => $auth_user->friendsActivities(),
            'friendsOfFriends' =>  $auth_user->friendsOfFriends()
        ], 200);
    }
}
