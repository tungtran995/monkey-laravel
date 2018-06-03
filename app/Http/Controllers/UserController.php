<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use JWTAuthException;
use Hash;


class UserController extends Controller

{

    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function register(Request $request){
        $user = $this->user->create([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => Hash::make($request->get('password'))
        ]);
        return response()->json([ "status" => 200 , "message" => "create_user_successfully"], 200);
    }
    
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
        $user = JWTAuth::authenticate($token);
        return response()->json(compact('token', 'user'));
    }
    
    
    // public function getUserInfo(Request $request){
    //     $user = JWTAuth::toUser($request->token);
    //     return response()->json( $user);
    // }
    
    public function show($id)
    {
       return User::find($id);
    }
    
    public function refresh()
    {
        $token = JWTAuth::getToken();
        $token = JWTAuth::refresh($token);
        return response()->json(compact('token'));
    }

    public function logout()
    {
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);
        return response()->json(['logout']);
    }
    
    public function profile()
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['error' => 'user_not_found'], 404);
        }
        return response()->json(compact('user'));
    }
}
