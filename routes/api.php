<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('posts')->group(function () {
        Route::get('/', 'App\Http\Controllers\PostsController@all');
        Route::post('/', 'App\Http\Controllers\PostsController@store');
    });

    Route::prefix('users')->group(function() {
        Route::post('/', 'App\Http\Controllers\UsersController@store');
        Route::post('/{username}/follow', 'App\Http\Controllers\UsersController@follow');
        Route::post('/{username}/unfollow', 'App\Http\Controllers\UsersController@unfollow');
    });
});
