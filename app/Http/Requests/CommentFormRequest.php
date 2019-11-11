<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class CommentFormRequest extends FormRequest
{
    abstract public function authorize();
    
    abstract public function save();

    public function rules()
    {
        return [
            'body' => 'required'
        ];
    }
}
