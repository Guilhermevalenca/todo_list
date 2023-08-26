<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request,$status = 200)
    {
        if(Auth::attempt($request->only('email','password'))) {
            $token = $request->user()->createToken('user_login');
            return response($token, $status);
        }
        return response('',401);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response('Revoked Token',200);
    }

}
