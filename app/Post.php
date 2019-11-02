<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = ['user_id', 'body', 'images'];
    protected $casts = ['images' => 'array'];
    protected $with = ['owner'];
    protected $appends = ['encodedImages'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function publish($post)
    {
        return static::create($post);
    }

    public function getEncodedImagesAttribute()
    {
        $encodedImages = [];

        foreach ($this->images as $image) {
            $encodedImages[] = Image::make(public_path('/storage/posts/' . $image))->encode('data-url');
        }

        return $encodedImages;
    }

    public function removeImages()
    {
        Storage::disk('public')->delete(
            array_map(function ($imageName) {
                return "posts/$imageName";
            }, $this->images)
        );
    }
}
