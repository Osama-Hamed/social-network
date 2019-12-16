<?php

namespace App\Http\Controllers;

use App\Post;

class PostFavoriteController extends Controller
{
    public function store(Post $post)
    {
		$post->favorite();
		   
		return response()->json(null, 204);
	}
	public function destroy(Post $post)
    {
		$post->unfavorite();
		
		return response()->json(null, 204);
	}
}
