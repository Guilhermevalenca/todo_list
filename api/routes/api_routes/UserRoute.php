<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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
