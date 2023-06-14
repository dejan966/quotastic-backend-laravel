<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function createUser(){

    }

    public function getUsers(){
        return User::all();
    }

    public function getCurrentUser(){
        if (Auth::check())
        {
            return Auth::user();
        }
        else
        {
            echo "You are not logged in";
        }
    }

    public function currUserUpvoted(){
        $userId = getCurrentUser()->id;
        $numberUpvotedQuotes = DB::Select('select COUNT(DISTINCT(v.*)) as quotesUpvoted, COUNT(q2.quote) as userQuotes from user u inner join vote v on u.id = v.user_id
        inner join quote q on q.id = v.quote_id inner join quote q2 on u.id = q2."userId"
        WHERE (u.id = ?) and (v.value = ?);', [$userId, true]);
        return UserResource::collection($numberUpvotedQuotes);
    }
    
    public function currUserUpvotes(){
        $userId = getCurrentUser()->id;
        $numberUpvotes = DB::Select('select COUNT(u2.*) as quotes from "user" u inner join "vote" v on u.id = v."userId"
        inner join quote q on q.id = v."quoteId" INNER JOIN "user" u2 on u2.id = v."userId"
        WHERE (u2.id != ?) and (v.value = ?)', [$userId, true]);
        return UserResource::collection($numberUpvotes);
    }

    //how many quotes the user upvoted
    public function userUpvoted(int $userId){
        $numberOfUpvotedQuotes = DB::Select('select COUNT(DISTINCT(v.*)) as quotesUpvoted, COUNT(q2.quote) as userQuotes from user u inner join vote v on u.id = v.user_id
        inner join quote q on q.id = v.quote_id inner join quote q2 on u.id = q2."userId"
        WHERE (u.id = ?) and (v.value = ?);', [$id, true]);
        return UserResource::collection($numberOfUpvotedQuotes);
    }
    
    //how many users has upvotes the user's quotes
    public function userUpvotes(int $userId){
        $numberOfUpvotes = DB::Select('select COUNT(u2.*) as quotes from "user" u inner join "vote" v on u.id = v."userId"
        inner join quote q on q.id = v."quoteId" INNER JOIN "user" u2 on u2.id = v."userId"
        WHERE (u2.id != ?) and (v.value = ?)', [$id, true]);
        return UserResource::collection($numberOfUpvotes);
    }

    public function updatePassword(Request $request){
        //get current user
        if(!empty($request->password) && !empty($request->confirm_password)){
            //hash password
            $updatePass = User::where('id', $id)->update(array('password' => $request->password));
        }
        return UserResource::collection($updatePass);
    }

    public function getById(Request $request){
        $user = User::where('id', $request->id);
        return UserResource::collection($user);
    }
    
    public function updateById(int $id, Request $request){
        $updatedUser = User::where('id', $id);
        return UserResource::collection($updatedUser);
    }
    
    public function deleteById(Request $request){
        $deletedUser = User::where('id', $request->id)->delete();
        return UserResource::collection($deletedUser);
    }
}
