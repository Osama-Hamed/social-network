<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use App\Services\UploadBase64Images;

class UpdatePostRequest extends PostFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('manage', $this->post);
    }

    public function save()
    {
        return tap($this->post, function ($post) {
            $post->removeImages();

            $post->update([
                'body' => $this->body,
                'images' => app(UploadBase64Images::class)->uploadMultiple($this->images),
                'privacy' => $this->privacy
            ]);
        })->refresh();
    }
}
