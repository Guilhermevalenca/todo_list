<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todo = TodoResource::collection(Todo::paginate());
        return response($todo,200);
    }
    public function show($id)
    {
        try {
            $todo = new TodoResource(Todo::findOrFail($id));
            return response($todo,200);
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
            $response = Todo::create($todo);
            return response($response,200);
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
