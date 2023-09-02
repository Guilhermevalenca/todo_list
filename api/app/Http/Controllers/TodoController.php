<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $response = [
            'todos' => TodoResource::collection(Todo::paginate(10)),
            'totalPage' => Todo::paginate()->lastPage()
        ];
        return response($response,200);
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
    public function findTodosByName(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);
            $name = $request->input('name') . '%';
            $todo = TodoResource::collection(Todo::where('name','LIKE',$name)->paginate());
            return response($todo,200);
        } catch (\Exception $e) {
            return $e;
        }
    }
    public function store(Request $request)
    {
        try {
            $todo = $request->validate([
                'name' => 'required',
                'user_id' => 'required'
            ]);
            Todo::create([
                'name' => $todo['name'],
                'user_id' => $todo['user_id']
            ]);
            return response('success',200);
        } catch (\Exception $e) {
            return response($e,304);
        }
    }
    public function update(Request $request)
    {
        try {
            $todo = $request->validate([
                'name' => 'required',
                'user' => 'required'
            ]);
            $todo = Todo::update($todo);
            return response($todo,200);
        } catch (QueryException $e) {
            return $e->errorInfo;
        }
    }
    public function update_status($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            $todo->update([
                'status' => !$todo['status']
            ]);
            return response($todo,200);
        } catch (QueryException $e) {
            return $e->errorInfo;
        }
    }
    public function delete(Request $request)
    {
        try {
            $todo = $request->validate([
                'id' => 'required'
            ]);
            $todo = Todo::destroy($todo['id']);
            return response($todo,200);
        } catch (QueryException $e) {
            return $e->errorInfo;
        }
    }
}
