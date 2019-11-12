<?php

namespace App\Http\Controllers;

use App\Post;

class PostFavoriteController extends Controller
{
    public function store(Post $post)
    {
   		$post->favorite();
	}
	public function destroy(Post $post)
    {
   		$post->unfavorite();
	}
}
