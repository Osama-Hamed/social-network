<?php

namespace App\Http\Controllers;

class ActivityController extends Controller
{
    public function index()
    {
    	return response()->json(auth()->user()->friendsActivities(), 200);
    }
}
