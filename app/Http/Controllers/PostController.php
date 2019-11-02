<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::latest('created_at')->get(), 200);
    }

    public function store(StorePostRequest $form)
    {
        return response()->json($form->save(), 201);
    }

    public function update(UpdatePostRequest $form, Post $post)
    {
    	return response()->json($form->save(), 200);
    }
}
