<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Arquivos de rotas para api criados dentro do diretorio api_routes, novos arquivos de rotas podem ser adicionados dentros do arquivo api/app/Providers/RouteServiceProvider.php


