<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['user_id', 'type'];
    protected $with = ['subject', 'maker'];

    public function subject()
    {
    	return $this->morphTo();
    }

    public function maker()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFriends($query, $user)
    {
        return $query->whereIn('user_id', $user->friendsIds());
    }
}
