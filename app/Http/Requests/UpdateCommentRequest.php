<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;

class UpdateCommentRequest extends CommentFormRequest
{
    public function authorize()
    {
        return Gate::allows('update', $this->comment);
    }

    public function save()
    {
        return tap($this->comment)->update(['body' => $this->body]);
    }
}
