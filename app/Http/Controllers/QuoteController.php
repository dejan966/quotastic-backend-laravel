<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Http\Resources\QuoteResource;

class QuoteController extends Controller
{
    public function mostLiked(){
        $mostLikedQuotes = Quote::orderBy('karma', 'DESC')->get();
        return QuoteResource::collection($mostLikedQuotes);
    }

    public function mostRecent(){
        $mostRecentQuotes = Quote::orderBy('posted_when', 'DESC')->get();
        return QuoteResource::collection($mostRecentQuotes);
    }

    public function userMostLikedQuotes(Request $request){
        $userMostLiked = Quote::where('user_id', '=', $request->id)->orderBy('karma', 'DESC')->get();
        return QuoteResource::collection($userMostLiked);
    }
    
    public function userMostRecentQuotes(Request $request){
        $userMostLiked = Quote::where('user_id', '=', $request->id)->orderBy('posted_when', 'DESC')->get();
        return QuoteResource::collection($userMostLiked);
    }
}
