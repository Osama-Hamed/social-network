<?php

namespace App\Http\Controllers;

use App\Comment;

class CommentFavoriteController extends Controller
{
    public function store(Comment $comment)
    {
		$comment->favorite();
		
		return response()->json(null, 204);
	}
	public function destroy(Comment $comment)
    {
		$comment->unfavorite();
		
		return response()->json(null, 204);
	}
}
