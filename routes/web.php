<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Users
Route::group([
    'name'=>'users.',
    'prefix'=>'users',
    'namespace'=>'User',
    'middleware'=>'auth',
], function(){
    Route::get('/', 'UserController@getUsers');
    Route::get('me', 'UserController@getCurrentUser');
    Route::get('me/upvoted', 'UserController@currUserUpvoted');
    Route::get('me/upvotes', 'UserController@currUserUpvotes');
    Route::get('upvoted/{id}', 'UserController@userUpvoted');
    Route::get('upvotes/{id}', 'UserController@userUpvotes');
    Route::patch('me/update-password', 'UserController@updatePassword');
    Route::get('{id}', 'UserController@getById');
    Route::patch('{id}', 'UserController@updateById');
    Route::delete('{id}', 'UserController@deleteById');
});

// Quotes
Route::group([
    'name'=>'quotes.',
    'prefix'=>'quotes',
    'namespace'=>'Quote'
], function(){
    Route::get('/', 'QuoteController@getQuotes');
    Route::get('random', 'QuoteController@randomQuote');
    Route::get('mostLiked', 'QuoteController@mostLiked');
    Route::get('recent', 'QuoteController@mostRecent');
    Route::group(['middleware'=>'auth'], function(){
        Route::get('{id}', 'QuoteController@getById');
        Route::patch('{id}', 'QuoteController@updateById');
        Route::delete('{id}', 'QuoteController@deleteById');
    });
});

// Votes
Route::group([
    'name'=>'votes.',
    'prefix'=>'votes',
    'namespace'=>'Vote'
], function(){
    Route::get('users/{id}', 'VoteController@findUserVotes');
    Route::get('/', 'VoteController@getVotes');
    Route::group(['middleware'=>'auth'], function(){
        Route::post('{id}/upvote', 'VoteController@createVote');
        Route::post('{id}/downvote', 'VoteController@createVote');
        Route::get('me', 'VoteController@findUserVotes');
    });
});
