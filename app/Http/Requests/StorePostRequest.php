<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Post;

class StorePostRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => 'required',
            'images.*' => 'base64image:jpg,jpeg,png'
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

    public function save()
    {
        return Post::publish([
            'user_id' => $this->user()->id,
            'body' => $this->body,
            'images' => $this->uploadImages()
        ])->load('owner');
    }
}
