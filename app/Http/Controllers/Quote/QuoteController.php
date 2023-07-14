<?php

namespace App\Http\Controllers\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Http\Resources\QuoteResource;

class QuoteController extends Controller
{
    public function createQuote(Request $request){
        return Quote::insert($request->data);
    }

    public function getById(int $id){
        $quote = Quote::where('id', $id)->get();
        return QuoteResource::collection($quote);
    }
    
    public function update(int $id, Request $request){
        if ($request->exists('karma')){
            return Quote::where('id', $id)->update(['karma' => $request->karma]);
        }
        return Quote::where('id', $id)->update(['quote' => $request->quote]);
    }
    
    public function deleteById(int $id){
        $deletedQuote = Quote::where('id', $id)->delete();
        return QuoteResource::collection($deletedQuote);
    }
    
    public function getQuotes(){
        return QuoteResource::collection(Quote::all());
    }
    
    public function randomQuote(){
        return Quote::all()->random();
    }

    public function mostLiked(){
        $mostLikedQuotes = Quote::orderBy('karma', 'DESC')->get();
        return QuoteResource::collection($mostLikedQuotes);
    }

    public function mostRecent(){
        $mostRecentQuotes = Quote::orderBy('posted_when', 'DESC')->get();
        return QuoteResource::collection($mostRecentQuotes);
    }

    public function userMostLikedQuotes(int $userId){
        $userMostRecent = Quote::where('user_id', $userId)->orderBy('karma', 'DESC')->get();
        return QuoteResource::collection($userMostRecent);
    }
    
    public function userMostRecentQuotes(int $userId){
        $userMostLiked = Quote::where('user_id', $userId)->orderBy('posted_when', 'DESC')->get();
        return QuoteResource::collection($userMostLiked);
    }
    
}
