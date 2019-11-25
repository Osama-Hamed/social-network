<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Traits\Favoritable;

class Post extends Model
{
    use Favoritable;
    
    protected $fillable = ['user_id', 'body', 'images', 'privacy'];
    protected $casts = ['images' => 'array'];
    protected $with = ['owner', 'comments.owner'];
    protected $withCount = ['comments', 'favorites'];
    protected $appends = ['encodedImages', 'isFavorited'];

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
        $encoded_images = [];

        foreach ($this->images as $image) {
            $encoded_images[] = Image::make(public_path('/storage/posts/' . $image))->encode('data-url');
        }

        return $encoded_images;
    }

    public function removeImages()
    {
        Storage::disk('public')->delete(
            array_map(function ($imageName) {
                return "posts/$imageName";
            }, $this->images)
        );
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function addComment($body)
    {
        return $this->comments()->create([
            'user_id' => auth()->id(),
            'body' => $body
        ]);
    }

    public function scopePublic($query)
    {
        return $query->where('privacy', 1);
    }

    public function scopePublicOrFriends($query)
    {
        return $query->where('privacy', 1)->orWhere('privacy', 2);
    }
}
