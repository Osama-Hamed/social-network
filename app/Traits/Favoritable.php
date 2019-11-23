<?php

namespace App\Traits;

use App\Favorite;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleted(function ($model) {
            $model->favorites->each->delete();
        });
    }

	public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function getIsFavoritedAttribute()
    {
        return !! $this->favorites()->where('user_id', auth()->id())->count();
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $this->favorites()->where($attributes)->exists()) return $this->favorites()->create($attributes);
    }
    
    public function unfavorite()
    {
        $this->favorites()->where('user_id', auth()->id())->get()->each->delete();
    }
}