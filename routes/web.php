<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;

// Rota raiz redireciona para login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas de autenticação (sem middleware)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    Route::resource('clientes', ClienteController::class);

    // Rota AJAX consulta de CEP (deve vir ANTES do resource para não colidir)
    Route::get('/clientes/cep/{cep}', [ClienteController::class, 'consultaCep'])
         ->name('clientes.cep');
});
