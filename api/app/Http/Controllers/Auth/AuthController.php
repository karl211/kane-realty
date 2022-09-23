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
            throw new AuthenticationException();
        }

        $token = $request->user()->createToken('auth_token');
 
        return response()->json(['token' => $token->plainTextToken]);
    }
    
    public function logout(Request $request)
    {
        // auth()->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();
      
        // Revoke all tokens...
        auth()->user()->tokens()->delete();
        
        return response()->json(null, 201);



        
        // Revoke the token that was used to authenticate the current request...
        // $request->user()->currentAccessToken()->delete();
        
        // // Revoke a specific token...
        // $user->tokens()->where('id', $tokenId)->delete();
    }

    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user(),
        ]);
    }
}
