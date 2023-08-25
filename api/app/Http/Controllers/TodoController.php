<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        try {
            $todo = $request->validate([
                'name' => 'required',
                'responsible' => 'required'
            ]);
            Todo::created($todo);
            return response('success',200);
        } catch (\Exception $e) {
            return response($e,304);
        }
    }
}
