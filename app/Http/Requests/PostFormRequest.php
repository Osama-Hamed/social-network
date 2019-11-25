<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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

    public function uploadImages()
    {
        if (! $images = $this->images) return [];

        $imagesNames = [];

        foreach ($images as $image) {
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $imageName = Carbon::now()->timestamp . '_' . uniqid() . '.' . $extension;
            $imagesNames[] = $imageName;

            Storage::disk('public')
                ->put("posts/$imageName", Image::make($image)
                ->encode($extension));
        }

        return $imagesNames;
    }
}
