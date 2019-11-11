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

    Route::post('/posts/{post}/comments', 'CommentController@store');
    Route::patch('/comments/{comment}', 'CommentController@update');
    Route::delete('/comments/{comment}', 'CommentController@destroy');
});
