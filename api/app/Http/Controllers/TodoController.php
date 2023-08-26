<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return response(Todo::all(),200);
    }
    public function show($id)
    {
        try {
            return response(Todo::findOrFail($id),200);
        } catch (\Exception $e) {
            return response($e,404);
        }
    }
    public function store(Request $request)
    {
        try {
            $todo = $request->validate([
                'name' => 'required',
                'user_id' => 'required'
            ]);
            $todo = Todo::create([
                'name' => $todo['name'],
                'user_id' => $todo['user_id']
            ]);
            return response($todo,200);
        } catch (\Exception $e) {
            return response($e,304);
        }
    }
    public function update(Request $request)
    {
        $todo = $request->validate([
            'name' => 'required',
            'user' => 'required'
        ]);
    }
}
