<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException("Email or password is not valid");
        }
        
        $token = $request->user()->createToken('auth-token');

        return [
            'message' => ['successfully logged in'],
            'token' => $token->plainTextToken
        ];
 
        // return response()->json(['user' => $request->user(), 'token' => $token->plainTextToken]);
    }
    
    public function logout(Request $request)
    {
        // auth()->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();
      
        // Revoke all tokens...
        // auth()->user()->currentAccessToken()->delete();
        // auth()->user()->currentAccessToken()->delete();
        auth()->user()->tokens()->delete();
        
        return response()->json([
            'message'=>'Successfully Logged out'
        ], 201);



        
        // Revoke the token that was used to authenticate the current request...
        // $request->user()->currentAccessToken()->delete();
        
        // // Revoke a specific token...
        // $user->tokens()->where('id', $tokenId)->delete();
    }

    public function getUser()
    {
        return response()->json([
            'data' => auth()->user()
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }
}
