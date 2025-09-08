<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthClubeController;
use App\Http\Controllers\ClubeController;

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

// Cadastro de usuário
Route::post('/usuario/register', [UserController::class, 'store']);

// Login de usuário
Route::post('/usuario/login', [AuthUserController::class, 'login']);

// Crud de usuário
Route::get('/usuario/show/{id}', [UserController::class, 'show']);
Route::put('/usuario/update/{id}', [UserController::class, 'update']);
Route::delete('/usuario/delete/{id}', [UserController::class, 'destroy']);
Route::post('/usuario/logout', [AuthUserController::class, 'logout']);

// Pesquisa de usuário
Route::get('/usuario', [UserController::class, 'pesquisa']);

// Cadastro de Clube
Route::post('/clube/register', [ClubeController::class, 'store']);

// Login de Clube
Route::post('/clube/login', [AuthClubeController::class, 'loginClube']);

// Rotas protegidas por token - Usuário
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/usuario/perfil', [AuthUserController::class, 'perfil']);
    Route::post('/usuario/logout', [AuthUserController::class, 'logout']);
    Route::delete('/usuario/destroy/{id}', [UserController::class, 'destroy']); 
});

// Rotas protegidas por token - Clube
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/clube/perfil', [AuthClubeController::class, 'perfil']);
    Route::post('/clube/logout', [AuthClubeController::class, 'logout']);
});