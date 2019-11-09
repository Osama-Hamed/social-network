<?php

namespace App\Http\Requests;

use App\Post;

class StorePostRequest extends PostFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save()
    {
        return Post::publish([
            'user_id' => $this->user()->id,
            'body' => $this->body,
            'images' => $this->uploadImages()
        ])->load('owner');
    }
}
