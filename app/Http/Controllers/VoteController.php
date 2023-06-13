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
        if(!empty($userVote)){
            if($userVote->value === $request->value){
                $deletedVote = deleteVote($id);
                //return Vote::insert()
            }
        }
        return Vote::insert($request->data, $id);
    }

    public function updateVote(int $id){
        $vote = Vote::where('id', $id);
        $updatedVote = Vote::update(array('value' => !($vote->value)));
        return VoteResource::collection($updatedVote);
    }

    public function deleteVote(int $id){
        $vote = Vote::where('id', $request->id)->delete();
        return VoteResource::collection($vote);
    }

    public function findUserVotes(int $userId){
        $votes = Vote::where('user_id', $userId)->whereNotNull('quote_id')->get();
        return VoteResource::collection($votes);
    }
    
    public function getVotes(){
        $votes = Vote::whereNotNull('quote_id')->get();
        return VoteResource::collection($votes);
    }
}
