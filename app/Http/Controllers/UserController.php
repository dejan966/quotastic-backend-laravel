<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function getUsers(){
        return User::all();
    }

    public function getCurrentUser(){
        //return user from the session
    }
    
    public function upvoted(){
        
    }
    
    public function upvotes(){
        
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
