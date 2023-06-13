<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
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


// Auth
Route::post('/auth/login', [LoginController::class, 'login']);
Route::post('/auth/register', [RegisterController::class, 'register']);

// User
Route::post('/users', [UserController::class, 'createUser']);
Route::get('/users/me', [UserController::class, 'getCurrentUser']);
Route::get('/users/me/upvoted', [UserController::class, 'currUserUpvoted']);
Route::get('/users/me/upvotes', [UserController::class, 'currUserUpvotes']);
Route::get('/users/upvotes/{id}', [UserController::class, 'userUpvoted']);
Route::get('/users/upvotes/{id}', [UserController::class, 'userUpvotes']);
Route::patch('/users/me/update-password', [UserController::class, 'updatePassword']);
Route::get('/users/{id}', [UserController::class, 'getById']);
Route::patch('/users/{id}', [UserController::class, 'updateById']);
Route::delete('/users/{id}', [UserController::class, 'deleteById']);

// Quotes
Route::post('/quotes', [QuoteController::class, 'createQuote']);
Route::get('/quotes', [QuoteController::class, 'getQuotes']);
Route::get('/quotes/random', [QuoteController::class, 'randomQuote']);
Route::get('/quotes/mostLiked', [QuoteController::class, 'mostLiked']);
Route::get('/quotes/recent', [QuoteController::class, 'mostRecent']);
Route::get('/quotes/mostLiked/users/{id}', [QuoteController::class, 'userMostLikedQuotes']);
Route::get('/quotes/recent/users/{id}', [QuoteController::class, 'userMostRecentQuotes']);
Route::get('/quotes/{id}', [QuoteController::class, 'getById']);
Route::patch('/quotes/{id}', [QuoteController::class, 'updateById']);
Route::delete('/quotes/{id}', [QuoteController::class, 'deleteById']);

// Votes
Route::post('/votes/{id}/upvote', [VoteController::class, 'createVote']);
Route::post('/votes/{id}/downvote', [VoteController::class, 'createVote']);
Route::get('/votes/users/{id}', [VoteController::class, 'findUserVotes']);
Route::get('/votes', [VoteController::class, 'getVotes']);
Route::get('/votes/me', [VoteController::class, 'findUserVotes']);