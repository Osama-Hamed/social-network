<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\StorePostRequest;

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
}
