<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;

Route::prefix('todo_list')
    ->controller(TodoController::class)
    ->whereNumber('id')
    ->group(function() {
        Route::get('','index');

        Route::middleware('api:sanctum')
            ->group(function() {
                Route::get('{id}','show');
                Route::post('','store');
                Route::put('{id}','update');
                Route::patch('{id}','update_status');
                Route::delete('','delete');
            });
    });
Route::prefix('users')
    ->controller(UserController::class)
    ->group(function() {
        Route::post('create','store');
    });
