<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\clubeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// cadastro de usuario
Route::post('/register', [UserController::class, 'store']);

// cadastro de Clube
Route::post('/registerClube', [ClubeController::class, 'store']);

// Login de usuário
Route::post('/login', [AuthController::class, 'login']);

// Login de Clube
Route::post('/loginClube', [ClubeController::class, 'loginClube']);

// Rotas protegidas por token
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/perfil', [AuthController::class, 'perfil']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
