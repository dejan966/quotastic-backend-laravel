<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Http\Resources\QuoteResource;

class QuoteController extends Controller
{
    public function mostLiked(){
        $mostLikedQuotes = Quote::all();
        return QuoteResource::collection($mostLikedQuotes);
    }
}
