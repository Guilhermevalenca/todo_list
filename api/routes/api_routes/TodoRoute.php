<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::prefix('todo_list')
    ->controller(TodoController::class)
    ->whereNumber('id')
    ->group(function() {
        Route::get('','index');
        Route::post('search','findTodosByName');

        Route::middleware('auth:sanctum')
            ->group(function() {
                Route::get('{id}','show');
                Route::post('','store');
                Route::put('{id}','update');
                Route::patch('{id}','update_status');
                Route::delete('','delete');
            });
    });
