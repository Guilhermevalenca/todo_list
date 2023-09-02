<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


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
Route::prefix('users')
    ->controller(UserController::class)
    ->group(function() {
        Route::post('create','store');

        Route::controller(AuthController::class)
            ->group(function() {
                Route::post('login','login');
                Route::post('logout','logout')->middleware('auth:sanctum');
            });

        Route::middleware('auth:sanctum')
            ->group(function() {
                Route::get('','index');
                Route::get('{id}','show');
                Route::post('','findUsersByName');
                Route::put('','update');
                Route::delete('','delete');
            });
    });
