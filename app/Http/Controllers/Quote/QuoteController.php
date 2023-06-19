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

    public function userMostLikedQuotes(Request $request){
        $userMostLiked = Quote::where('user_id', $request->id)->orderBy('karma', 'DESC')->get();
        return QuoteResource::collection($userMostLiked);
    }
    
    public function userMostRecentQuotes(Request $request){
        $userMostLiked = Quote::where('user_id', $request->id)->orderBy('posted_when', 'DESC')->get();
        return QuoteResource::collection($userMostLiked);
    }
    
    public function getById(int $id){
        $userMostLiked = Quote::where('id', $id)->get();
        return QuoteResource::collection($userMostLiked);
    }
    
    public function updateById(int $id, Request $request){
        $userMostLiked = Quote::where('id', $id)->update(array('quote' => $request->quote));
        return QuoteResource::collection($userMostLiked);
    }
    
    public function deleteById(int $id){
        $userMostLiked = Quote::where('id', $id)->delete();
        return QuoteResource::collection($userMostLiked);
    }
}
