<?php

namespace App\Http\Controllers\Vote;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\VoteResource;

class VoteController extends Controller
{
    public function createVote(int $id, Request $request){
        $currUserId = Auth::user()->id;
        $userVote = Vote::where('quote_id', $id)->where('user_id', $currUserId)->get();
        error_log($request->value);
        if(!$userVote->isEmpty()){
            if($userVote[0]['value'] === $request->value){
                //karma+=2
                return DB::delete('delete from votes where (value = ?) and (quote_id = ?) and (user_id = ?)', [$request->value, $id, $currUserId]);
            }
            return $this->updateVote($userVote[0]['id'], $request->value);
        }     
        return Vote::insert(array('value' => $request->value, 'quote_id' => $id, 'user_id' => $currUserId));
    }

    public function updateVote(int $id, int $value){
        $vote = Vote::where('id', $id)->update(['value'=>$value]);
        return $vote;
    }

    public function deleteVote(int $id){
        $vote = Vote::where('id', $id)->delete();
        //return VoteResource::collection($vote);
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
