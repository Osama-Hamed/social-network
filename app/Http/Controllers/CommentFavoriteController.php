<?php

namespace App\Http\Controllers;

use App\Comment;

class CommentFavoriteController extends Controller
{
    public function store(Comment $comment)
    {
   		$comment->favorite();
	}
	public function destroy(Comment $comment)
    {
   		$comment->unfavorite();
	}
}
