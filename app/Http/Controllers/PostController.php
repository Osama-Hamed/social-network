<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index()
    {
        return response()->json([
            'posts' => Post::homePosts(request('skip'), request('take')),
            'totalPostsCount' => Post::homePostsTotalCount()
        ], 200);
    }

    public function show(Post $post)
    {
        if ($post->isAccessibleFor(auth()->user())) return response()->json($post, 200);

        return response()->json(null, 404);
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
