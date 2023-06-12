<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * Handle account registration request
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request) 
    {
        error_log($request->email);
/*         $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]); */

        /* try{
            $imageName = Str::random().'.'.$request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('product/image', $request->image,$imageName);
            Product::create($request->post()+['image'=>$imageName]);

            return response()->json([
                'message'=>'Product Created Successfully!!'
            ]);
        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return response()->json([
                'message'=>'Something goes wrong while creating a product!!'
            ],500);
        } */
/*         $user = User::create($request->validated());

        auth()->login($user);

        return redirect('/')->with('success', "Account successfully registered."); */
    }
}
