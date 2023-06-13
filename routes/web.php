<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\VoteController;

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