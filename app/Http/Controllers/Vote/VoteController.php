<?php

namespace App\Http\Controllers\Vote;

use DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Quote\QuoteController;
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
        if(!$userVote->isEmpty()){
            if($userVote[0]['value'] === $request->value){
                $this->setKarma($id, $request, 1, true);
                return $this->deleteVote($userVote[0]['id']);
            }
            $this->setKarma($id, $request, 2, false);
            return $this->updateVote($userVote[0]['id'], $request->value);
        }
        $this->setKarma($id, $request, 1, false);
        return Vote::insert(array('value' => $request->value, 'quote_id' => $id, 'user_id' => $currUserId));
    }

    public function updateVote(int $id, int $value){
        $vote = Vote::where('id', $id)->update(['value'=>$value]);
        return $vote;
    }

    public function deleteVote(int $id){
        $vote = Vote::where('id', $id)->delete();
        return VoteResource::collection($vote);
    }

    public function setKarma(int $id, Request $request, int $karma, bool $flag){
        $quote = (new QuoteController)->getById($id);
        if($flag){
            $quoteKarma = $request->value ? $quote[0]['karma'] - $karma : $quote[0]['karma'] + $karma;
            $request->request->add(['karma' => $quoteKarma]);
            $updateKarma = (new QuoteController)->update($id, $request);
            return;
        }
        $quoteKarma = $request->value ? $quote[0]['karma'] + $karma : $quote[0]['karma'] - $karma;
        $request->request->add(['karma' => $quoteKarma]);
        $updateKarma = (new QuoteController)->update($id, $request);
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
