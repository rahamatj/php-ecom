<?php

Route::get('/', [
    'uses' => 'PostsController@index',
    'as' => '/'
]);