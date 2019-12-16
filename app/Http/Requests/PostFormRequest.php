<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class PostFormRequest extends FormRequest
{
    abstract public function authorize();

    abstract public function save();

    public function rules()
    {
        return [
            'body' => 'required',
            'images.*' => 'base64image:jpg,jpeg,png',
            'privacy' => 'required|in:1,2,3'
        ];
    }
}
