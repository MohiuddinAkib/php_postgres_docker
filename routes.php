<?php

use Pecee\SimpleRouter\SimpleRouter;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Access-Control-Allow-Origin, Access-Control-Allow-Headers');
header('Content-Type: application/json');

SimpleRouter::group(['prefix' => '/api/v1'], function () {
    SimpleRouter::get('/posts', 'PostController@index')->name('api.posts');
    SimpleRouter::get('/posts/{post}', 'PostController@show')->name('api.post');
    SimpleRouter::post('/posts', 'PostController@store')->name('api.post.store');
});