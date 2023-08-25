<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        try {
            $user = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'position' => 'required'
            ]);
            $user = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'position' => $user['position'],
                'password' => bcrypt($user['password'])
            ]);
            return response($user,201);
        } catch (\Exception $e) {
            return $e;
        }
    }
}
