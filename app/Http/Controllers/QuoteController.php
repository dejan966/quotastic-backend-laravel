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
}
