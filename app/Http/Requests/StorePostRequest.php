<?php

namespace App\Http\Requests;

use App\Post;
use App\Services\UploadBase64Images;

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
        return Post::create([
            'user_id' => $this->user()->id,
            'body' => $this->body,
            'images' => app(UploadBase64Images::class)->uploadMultiple($this->images),
            'privacy' => $this->privacy
        ])->fresh();
    }
}
