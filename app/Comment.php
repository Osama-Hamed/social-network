<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Favoritable;

class Comment extends Model
{
	use Favoritable;

    protected $fillable = ['user_id', 'body'];
    protected $withCount = ['favorites'];
    protected $appends = ['isFavorited'];

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }
}
