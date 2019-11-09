<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Post;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $form, Post $post)
    {
        return response()->json($form->save(), 201);
    }
}
