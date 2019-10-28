<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;

class Post extends Model
{
    protected $fillable = ['user_id', 'body', 'images'];
    protected $casts = ['images' => 'array'];
    protected $with = ['owner'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function publish($post)
    {
        return static::create($post);
    }
}
