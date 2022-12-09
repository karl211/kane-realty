<?php

namespace App\Http\Controllers\Auth;

use App\Models\Branch;
use App\Mail\TestEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Mail;

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

    public function getUser(Request $request)
    {
        // $data = ['message' => 'This is a test!'];

        // Mail::to('k.monteadora@gmail.com')->send(new TestEmail($data));

        

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

    public function sendMail(Requset $request)
    {
        $input = ['message' => 'This is a test!'];

        Mail::to('k.monteadora@gmail.com')->send(new SendGrid($input));
    }
}
