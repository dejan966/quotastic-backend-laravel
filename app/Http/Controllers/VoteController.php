<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Vote;
use App\Http\Resources\VoteResource;

class VoteController extends Controller
{
    public function createVote(int $id, Request $request){
        $userVote = Vote::where('quote_id', $id).pluck('value'); //add current user to the where
        if(count($userVote) > 0){
            if($userVote->value === $request->value){
                
            }
        }
    }

    public function updateVote(int $id){
        $vote = Vote::where('id', $id);
        $updatedVote = Vote::update(array('value' => !($vote->value)));
        return VoteResource::collection($vote);
    }

    public function deleteVote(int $id){
        $vote = Vote::where('id', $request->id)->delete();
    }
}
