<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VerificationController;

Route::prefix('users')
    ->controller(UserController::class)
    ->group(function() {
        Route::post('create','store');

        //autenticando token e revogando token
        Route::controller(AuthController::class)
            ->group(function() {
                Route::post('login','login');
                Route::post('logout','logout')->middleware('auth:sanctum');
            });

        //necessita de token para acessar estas funcionalidades
        Route::middleware('auth:sanctum')
            ->group(function() {
                Route::get('','index');
                Route::get('{id}','show');
                Route::post('','findUsersByName');
                Route::put('','update');
                Route::delete('','delete');
            });
    });

//verificação de email
Route::prefix('email')
    ->controller(VerificationController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('verify/{id}','verify')->name('verification.verify');
        Route::get('resend','resend')->name('verification.resend');
    });
