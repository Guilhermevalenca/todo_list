<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Arquivos de rotas para api criados dentro do diretorio api_routes, novos arquivos de rotas podem ser adicionados dentros do arquivo api/app/Providers/RouteServiceProvider.php

Route::prefix('email')
    ->controller(VerificationController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('verify/{id}','verify')->name('verification.verify');
        Route::get('resend','resend')->name('verification.resend');
    });
