<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(auth()->user()->relatedPosts(), 200);
    }

    public function store(StorePostRequest $form)
    {
        return response()->json($form->save(), 201);
    }

    public function update(UpdatePostRequest $form, Post $post)
    {
    	return response()->json($form->save(), 200);
    }

    public function destroy(Post $post)
    {
        $this->authorize('manage', $post);

        tap($post)->removeImages()->delete();

        return response()->json(null, 204);
    }
}
