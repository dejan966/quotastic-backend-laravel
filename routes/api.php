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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'name'=>'auth.',
    'prefix'=>'auth',
    'namespace'=>'Auth'
], function(){
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});

Route::group([
    'name'=>'users.',
    'prefix'=>'auth',
    'namespace'=>'User'
], function(){
    Route::get('signout', 'UserController@logout');
});


