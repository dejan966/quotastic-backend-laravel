<?php

namespace App\Http\Controllers\User;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUsers(){
        return UserResource::collection(User::all());
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
        $userId = $this->getCurrentUser()->id;
        $numberUpvotedQuotes = DB::Select('SELECT COUNT(DISTINCT(v.*)) as quotesUpvoted, COUNT(q2.quote) as userQuotes from users u inner join votes v on u.id = v.user_id
        inner join quotes q on q.id = v.quote_id inner join quotes q2 on u.id = q2."user_id"
        WHERE (u.id = ?) and (v.value = ?);', [$userId, true]);
        return $numberUpvotedQuotes;
    }
    
    public function currUserUpvotes(){
        $userId = $this->getCurrentUser()->id;
        $numberUpvotes = DB::Select('select COUNT(u2.*) as quotes from users u inner join votes v on u.id = v.user_id
        inner join quotes q on q.id = v.quote_id INNER JOIN users u2 on u2.id = v.user_id
        WHERE (u2.id != ?) and (v.value = ?)', [$userId, true]);
        return $numberUpvotes;
    }

    //how many quotes the user upvoted
    public function userUpvoted(int $userId){
        $numberOfUpvotedQuotes = DB::Select('SELECT COUNT(DISTINCT(v.*)) as quotesUpvoted, COUNT(q2.quote) as userQuotes from users u inner join votes v on u.id = v.user_id
        inner join quotes q on q.id = v.quote_id inner join quotes q2 on u.id = q2.user_id
        WHERE (u.id = ?) and (v.value = ?);', [$userId, true]);
        return $numberOfUpvotedQuotes;
    }
    
    //how many users has upvotes the user's quotes
    public function userUpvotes(int $userId){
        $numberOfUpvotes = DB::Select('select COUNT(u2.*) as quotes from users u inner join votes v on u.id = v.user_id
        inner join quotes q on q.id = v.quote_id INNER JOIN users u2 on u2.id = v.user_id
        WHERE (u2.id != ?) and (v.value = ?)', [$userId, true]);
        return $numberOfUpvotes;
    }

    public function updatePassword(int $id, Request $request){
        if(!empty($request->password) && !empty($request->confirm_password)){
            $updatePass = User::where('id', $id)->update(array('password' => Hash::make($request->password)));
        }
    }

    public function getById(int $id){
        $user = User::where('id', $id)->get();
        return UserResource::collection($user);
    }
    
    public function updateById(int $id, Request $request){
        $updatedUser = User::where('id', $id)->get();
        return UserResource::collection($updatedUser);
    }
    
    public function deleteById(int $id){
        $deletedUser = User::where('id', $id)->delete();
        return UserResource::collection($deletedUser);
    }

    public function logout()
    {
        Cookie::queue(Cookie::forget('access_token'));
        Cookie::queue(Cookie::forget('refresh_token'));
        Auth::logout();
        return response()->json(['message' => 'Logged Out'], 200);
    }
}
