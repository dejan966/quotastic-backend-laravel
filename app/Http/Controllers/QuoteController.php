<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Http\Resources\QuoteResource;

class QuoteController extends Controller
{
    public function createQuote(Request $request){
        return Quote::insert($request->data);
    }
    
    public function getQuotes(){
        return Quote::all();
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
    
    public function getById(Request $request){
        $userMostLiked = Quote::where('id', $request->id)->get();
        return QuoteResource::collection($userMostLiked);
    }
    
    public function updateById(int $id, Request $request){
        $userMostLiked = Quote::where('id', $id)->update(array('quote' => $request->quote));
        return QuoteResource::collection($userMostLiked);
    }
    
    public function deleteById(Request $request){
        $userMostLiked = Quote::where('id', $request->id)->delete();
        return QuoteResource::collection($userMostLiked);
    }
}
