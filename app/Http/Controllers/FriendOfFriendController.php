<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendOfFriendController extends Controller
{
    public function index()
    {
        $frindsOfFriends = auth()->user()->friendsOfFriends(3);

        return response()->json($frindsOfFriends, 200);
    }
}
