<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    protected $fillable = [
        'gender', 'birthday', 'bio', 'country', 'city', 'avatar'
    ];

    protected $appends = ['avatarPath'];

    public function getAvatarPathAttribute()
    {
        return "/storage/avatars/$this->avatar";
    }

    public function removeAvatar()
    {
        if ($this->avatar !== 'default.png') Storage::disk('public')->delete("avatars/$this->avatar");
    }
}
