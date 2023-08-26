<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(Request $request)
    {
        try{
            return response($request->user(),200);
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function showTodos(Request $request)
    {
        try {
            return response($request->user()->todos,200);
        } catch (\Exception $e) {
            return response($e,404);
        }
    }
    public function store(Request $request)
    {
        try {
            $user = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6',
                'position' => 'required'
            ]);
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'position' => $user['position'],
                'password' => bcrypt($user['password'])
            ]);
            $auth = new AuthController();
            return $auth->login($request,201);
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function update(Request $request)
    {
        $insertData = function($old, $new = null) { //função que testa se o novo dado existe, caso não exista inseri o antigo dado
            return $new == null ? $old : $new;
        };
        try {
            $user = $request->user();
            $user->update([
                'name' => $insertData($user['name'], $request->input('name')),
                'email' => $insertData($user['email'], $request->input('email')),
                'position' => $insertData($user['position'], $request->input('position')),
                'password' => empty($request->input('password')) ? $user['password'] : bcrypt($request->input('password'))
            ]);
            return response($user,200);
        } catch (\Exception $e) {
            return response($e,304);
        }
    }
    public function delete(Request $request)
    {
        try {
            return $request->user()->delete();
        } catch (\Exception $e) {
            return $e;
        }
    }
}
