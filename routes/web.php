<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\UserController;

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

// User
Route::controller(UserController::class)->group(function(){
    Route::post('/users', 'createUser');
    Route::get('/users', 'getUsers');
    Route::get('/users/me', 'getCurrentUser');
    Route::get('/users/me/upvoted', 'currUserUpvoted');
    Route::get('/users/me/upvotes', 'currUserUpvotes');
    Route::get('/users/upvotes/{id}', 'userUpvoted');
    Route::get('/users/upvotes/{id}', 'userUpvotes');
    Route::patch('/users/me/update-password', 'updatePassword');
    Route::get('/users/{id}', 'getById');
    Route::patch('/users/{id}', 'updateById');
    Route::delete('/users/{id}', 'deleteById');
});

// Quotes
Route::controller(QuoteController::class)->group(function(){
    Route::post('/quotes', 'createQuote');
    Route::get('/quotes', 'getQuotes');
    Route::get('/quotes/random', 'randomQuote');
    Route::get('/quotes/mostLiked', 'mostLiked');
    Route::get('/quotes/recent', 'mostRecent');
    Route::get('/quotes/mostLiked/users/{id}', 'userMostLikedQuotes');
    Route::get('/quotes/recent/users/{id}', 'userMostRecentQuotes');
    Route::get('/quotes/{id}', 'getById');
    Route::patch('/quotes/{id}', 'updateById');
    Route::delete('/quotes/{id}', 'deleteById');
});

// Votes
Route::controller(VoteController::class)->group(function(){
    Route::post('/votes/{id}/upvote', 'createVote');
    Route::post('/votes/{id}/downvote', 'createVote');
    Route::get('/votes/users/{id}', 'findUserVotes');
    Route::get('/votes', 'getVotes');
    Route::get('/votes/me', 'findUserVotes');
});
