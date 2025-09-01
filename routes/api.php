<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthClubeController;
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
Route::post('/login', [AuthUserController::class, 'login']);

// Login de Clube
Route::post('/loginClube', [ClubeController::class, 'loginClube']);

Route::get('/show', [UserController::class, 'show']);
Route::get('/update', [UserController::class, 'update']);
Route::get('/delete', [UserController::class, 'destroy']);

// Rotas protegidas por token
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/perfil', [AuthUserController::class, 'perfil']);
    Route::post('/logout', [AuthUserController::class, 'logout']);
});

// Rotas protegidas por token
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/perfil', [AuthClubeController::class, 'perfil']);
    Route::post('/logout', [AuthClubeController::class, 'logout']);
});

