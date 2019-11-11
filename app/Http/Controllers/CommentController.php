<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $form, Post $post)
    {
        return response()->json($form->save(), 201);
    }

    public function update(UpdateCommentRequest $form, Comment $comment)
    {
    	return response()->json($form->save(), 200);
    }
}
