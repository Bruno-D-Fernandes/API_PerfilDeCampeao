<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthClubeController;
use App\Http\Controllers\clubeController;
use App\Http\Controllers\PostagemController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\SearchUsuarioController;

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
        Route::put('/postagem/{id}', [PostagemController::class, 'update']);
        Route::delete('/postagem/{id}', [PostagemController::class, 'destroy']);
    });
});

// Postagem pública (index, show)
Route::get('/postagem', [PostagemController::class, 'index']);
Route::get('/postagem/{id}', [PostagemController::class, 'show']);

//Clube

Route::prefix('clube')->group(function () {
    Route::post('/register', [clubeController::class, 'store']);
    Route::post('/login', [AuthClubeController::class, 'loginClube']);

    Route::middleware('auth:sanctum')->group(function() {
        Route::get('/perfil', [AuthClubeController::class, 'perfil']);
        Route::post('/logout', [AuthClubeController::class, 'logout']);
        Route::put('/update/{id}', [clubeController::class, 'update']);
        Route::delete('/destroy/{id}', [clubeController::class, 'destroy']);



        Route::get('/jogadores', [SearchUsuarioController::class, 'index']); // Rota para buscar jogadores

        // 💡 ROTAS DE OPORTUNIDADE (PROTEGIDAS) INSERIDAS NOVAMENTE
        Route::post('/oportunidade', [OportunidadeController::class, 'store']);
        Route::put('/oportunidade/{id}', [OportunidadeController::class, 'update']);
        Route::delete('/oportunidade/{id}', [OportunidadeController::class, 'destroy']);
    });
});

// ... e as rotas públicas (index, show) no final do arquivo:
Route::get('/oportunidade', [OportunidadeController::class, 'index']);
Route::get('/oportunidade/{id}', [OportunidadeController::class, 'show']);

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
