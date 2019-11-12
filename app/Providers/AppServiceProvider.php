<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Post;
use App\Observers\PostObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $format = str_replace(
                ['data:image/', ';', 'base64',],
                ['', '', '',],
                $explode[0]
            );

            // check file format
            if (!in_array($format, $parameters)) return false;

            // check base64 format
            if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) return false;

            return true;
        });
    
        Validator::replacer('base64image', function($message, $attribute, $rule, $parameters) {
            return str_replace(':values', join(',', $parameters), $message);
        });

        Post::observe(PostObserver::class);
    }
}
