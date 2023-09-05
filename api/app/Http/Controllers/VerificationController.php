<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response('invalid url',401);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        return response('OK',200);
    }
    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response('email ja verificado',400);
        }
        auth()->user()->sendEmailVerificationNotification();
        return response('Link de verificação de e-mail enviado em seu ID de e-mail',200);
    }
}
