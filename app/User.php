<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;
use App\Traits\Friendable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 'gender', 'birthday', 'bio', 'country', 'city', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['avatarPath'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getAvatarPathAttribute()
    {
        return "/storage/avatars/$this->avatar";
    }

    public function removeAvatar()
    {
        if ($this->avatar !== 'default.png') Storage::disk('public')->delete("avatars/$this->avatar");
    }

    public function relatedPosts()
    {
        return $this->posts->merge($this->friendsPosts())->sortByDesc('created_at')->values()->all();
    }

    public function profilePosts()
    {
        $authUser = auth()->user();

        if ($this->is($authUser)) return $this->posts()->latest()->get();

        if ($this->isFriendOf($authUser)) return $this->posts()->publicOrFriendsPrivacy()->latest()->get();

        return $this->posts()->publicPrivacy()->latest()->get();
    }

    public static function search($q)
    {
        return static::where('first_name', 'like', "%$q%")->orWhere('last_name', 'like', "%$q%")->latest()->get();
    }
}
