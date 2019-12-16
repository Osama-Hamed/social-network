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
        'first_name', 'last_name', 'username', 'email', 'password'
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

    protected $with = ['profile'];

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

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public static function search($q, $take = 50)
    {
        return static::where('first_name', 'like', "%$q%")->orWhere('last_name', 'like', "%$q%")->latest()->take($take)->get();
    }

    public function friendsActivities($take = 10)
    {
        return Activity::friends($this)->latest()->take($take)->get();
    }

    public function profilePosts($take = 50)
    {
        $authUser = auth()->user();
        if ($this->is($authUser)) return $this->posts()->latest()->take($take)->get();
        if ($this->isFriendOf($authUser)) return $this->posts()->publicOrFriendsPrivacy()->latest()->take($take)->get();
        return $this->posts()->publicPrivacy()->latest()->take($take)->get();
    }
}
