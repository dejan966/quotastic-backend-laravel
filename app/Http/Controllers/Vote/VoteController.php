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
        //error_log($userVote[0]['value']);
        if(!$userVote->isEmpty()){
            error_log('5');
            if($userVote[0]['value'] == $request->value){
                //karma+=2
                return DB::delete('delete from votes where (value = ?) and (quote_id = ?) and (user_id = ?)', [$request->value, $id, $currUserId]);
            }
            $update = $this->updateVote($userVote[0]['id']);
            //return $update;
        }     
        return DB::insert('insert into votes (value, quote_id, user_id) values (?, ?, ?)', ['true', $id, $currUserId]);
        //return Vote::insert(array('true', $id, $currUserId));
    }

    public function updateVote(int $id){
        $vote = Vote::where('id', $id)->get();
        $updatedVote = Vote::update(array('value' => !($vote[0]['value'])));
        return VoteResource::collection($updatedVote);
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
