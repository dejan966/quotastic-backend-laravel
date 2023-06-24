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
            $quote = (new QuoteController)->getById($userVote[0]['quote_id']);
            if($userVote[0]['value'] === $request->value){
                $quoteKarma = $request->value ? $quote[0]['karma'] - 1 : $quote[0]['karma'] + 1;
                error_log($quoteKarma);
                $request->request->add(['karma' => $quote[0]['karma']]); //add karma to request
                $updateKarma = (new QuoteController)->update($id, $request);
                return $this->deleteVote($userVote[0]['id']);
            }
            $quoteKarma = $request->value ? $quote[0]['karma'] + 2 : $quote[0]['karma'] - 2;
            error_log($quoteKarma);
            //$updateKarma = (new QuoteController)->update($id, $request);
            return $this->updateVote($userVote[0]['id'], $request->value);
        }
        $quote = (new QuoteController)->getById($id);
        $quoteKarma = $request->value ? $quote[0]['karma'] + 1 : $quote[0]['karma'] - 1;
        error_log($quoteKarma);
        $updateKarma = (new QuoteController)->update($id, $request);
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

    public function findUserVotes(int $userId){
        $votes = Vote::where('user_id', $userId)->whereNotNull('quote_id')->get();
        return VoteResource::collection($votes);
    }
    
    public function getVotes(){
        $votes = Vote::whereNotNull('quote_id')->get();
        return VoteResource::collection($votes);
    }
}
