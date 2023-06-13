<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
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
