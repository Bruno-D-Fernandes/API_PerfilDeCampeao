<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthClubeController;
use App\Http\Controllers\ClubeController;
use App\Http\Controllers\PostagemController;
use App\Http\Controllers\AdmController;
use Illuminate\Support\Facades\Broadcast;

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

//usuario
Route::prefix('usuario')->group(function () {
    Route::post('/register', [UserController::class, 'store']);
    Route::post('/login', [AuthUserController::class, 'login']);
    Route::get('/show', [UserController::class, 'show']);
    Route::put('/update/{id}', [UserController::class, 'update']);
    Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    Route::post('/logout', [AuthUserController::class, 'logout']); 

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/perfil', [AuthUserController::class, 'perfil']);
        Route::post('/logout', [AuthUserController::class, 'logout']);
        Route::delete('/destroy/{id}', [UserController::class, 'destroy']);

        // Postagem protegida
        Route::post('/postagem', [PostagemController::class, 'store']);

        // Seguir e deixar de seguir protegidos
        Route::post('/{id}/seguir', [UserController::class, 'seguirUsuario']);

        Route::post('/{id}/deixar-de-seguir', [UserController::class, 'deixarDeSeguirUsuario']);
    });
});

//Clube

Route::prefix('clube')->group(function () {
    Route::post('/register', [ClubeController::class, 'store']);
    Route::post('/login', [AuthClubeController::class, 'loginClube']);

    Route::middleware('auth:sanctum')->group(function() {               // Middleware AQUI
        Route::get('/perfil', [AuthClubeController::class, 'perfil']);
        Route::post('/logout', [AuthClubeController::class, 'logout']);

        // Seguir e deixar de seguir clube protegidos
        Route::post('/{id}/seguir', [UserController::class, 'seguirClube']);
        Route::post('/{id}/deixar-de-seguir', [UserController::class, 'deixarDeSeguirClube']);
    });
});

//Admin
Route::prefix('admin')->group(function () {
    Route::post('/login', [AdmController::class, 'loginAdm']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/perfil', [AdmController::class, 'perfilAdm']);
        Route::post('/logout', [AdmController::class, 'logoutAdm']);
    });
});


// Route::get('/clube/show', [ClubeController::class, 'show']);
// Route::put('/clube/update/{id}', [ClubeController::class, 'update']);
// Route::delete('/clube/delete/{id}', [ClubeController::class, 'destroy']);

// Rotas protegidas por token - Usuário


// Rotas protegidas por token - Clube
