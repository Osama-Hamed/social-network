<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'body'];

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }
}
