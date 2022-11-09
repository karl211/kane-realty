<?php

namespace App\Http\Controllers\Auth;

use App\Models\Branch;
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
    }
    
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        
        return response()->json([
            'message'=>'Successfully Logged out'
        ], 201);
    }

    public function getUser()
    {
        return response()->json([
            'data' => auth()->user()->where('branch_id', 1)->first()
        ], 200);
    }

    public function getBranches()
    {
        $branches = Branch::with('locations')->get();
        
        return response()->json([
            'data' => $branches
        ], 200);
    }
}
