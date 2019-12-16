<?php

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/user', 'AuthController@user');
        Route::post('/logout', 'AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/posts', 'PostController@index');
    Route::post('/posts', 'PostController@store');
    Route::patch('/posts/{post}', 'PostController@update');
    Route::delete('/posts/{post}', 'PostController@destroy');
    Route::get('/posts/{post}', 'PostController@show');

    Route::post('/posts/{post}/comments', 'CommentController@store');
    Route::patch('/comments/{comment}', 'CommentController@update');
    Route::delete('/comments/{comment}', 'CommentController@destroy');

    Route::post('/posts/{post}/favorites', 'PostFavoriteController@store');
    Route::delete('/posts/{post}/favorites', 'PostFavoriteController@destroy');

    Route::post('/comments/{comment}/favorites', 'CommentFavoriteController@store');
    Route::delete('/comments/{comment}/favorites', 'CommentFavoriteController@destroy');

    Route::get('/profiles/{user}', 'ProfileController@show');
    Route::patch('/profiles/{user}', 'ProfileController@update');

    Route::post('/friendships', 'FriendshipController@store');
    Route::patch('/friendships/{user}', 'FriendshipController@update');
    Route::delete('/friendships/{user}', 'FriendshipController@destroy');

    Route::get('/home', 'HomeController');
    
    Route::get('/search', 'SearchController@show');
});
