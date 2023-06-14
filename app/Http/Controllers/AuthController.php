<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
/*         $this->guard()->login($user);
        return response()->json([
            'user' => $user,
            'message' => 'Registration successful'
        ], 200); */

        $access_token = Auth::login($user);
        $refresh_token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorization' => [
                'access_token' => $access_token,
                'refresh_token' => $refresh_token,
                'type' => 'bearer',
            ]
        ]);
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:5'],
        ]);
    }

    /**
     * Updates the refresh token in the database.
     *
     * @param int $id
     * @param string $token
     * @return \App\Http\Resources\UserResource
     */
    protected function updateRtHash(int $id, $token){
        $user = User::where('id', $id)->update(array('refresh_token' => $token));
        return $user;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    protected function guard()
    {
        return Auth::guard();
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $access_token = Auth::attempt($credentials);
        $refresh_token = Auth::attempt($credentials);

        if (!$access_token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        //$user = $this->updateRtHash($request->id, $token);
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'access_token' => $access_token,
                'refresh_token' => $refresh_token,
                'type' => 'bearer',
            ]
        ]);
    }
    
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged Out'], 200);
    }
}
