<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = UserResource::collection(User::paginate());
        return response($users, 200);
    }
    public function show($id)
    {
        try{
            $user = new UserResource(User::findOrFail($id));
            return response($user,200);
        } catch (QueryException $e) {
            return $e;
        }
    }
    public function findUsersByName(Request $request)
    {
        try {
            $validate = $request->validate([
                'partialName' => 'required'
            ]);
            $partialName = '%' . $validate['partialName'] . '%';
            $users = UserResource::collection(User::where('name','LIKE',$partialName)->get());
            return response($users,200);
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
        } catch (QueryException $e) {
            return response($e->errorInfo,409);
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
