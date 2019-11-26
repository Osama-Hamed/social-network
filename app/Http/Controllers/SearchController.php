<?php

namespace App\Http\Controllers;

class SearchController extends Controller
{
    public function show()
    {
    	request()->validate([
    		'q' => 'required|string',
    		'r' => 'required|string|in:posts,users'
    	]);

    	
    	$model = 'App\\' . ucfirst(str_singular(request('r')));

    	return response()->json($model::search(request('q')), 200);
    }
}
