<?php

namespace App\Http\Requests;

class StoreCommentRequest extends CommentFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function save()
    {
        return $this->post->addComment($this->body)->load('owner');
    }
}
