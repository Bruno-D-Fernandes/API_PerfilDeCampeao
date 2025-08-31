<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Hash;

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

use App\Http\Controllers\AuthController;

Route::post('/cadastro', [UserController::class, 'store']);

// Login de usuário
Route::post('/login', [AuthController::class, 'login']);

// Rotas protegidas por token
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/perfil', [AuthController::class, 'perfil']);
    Route::post('/logout', [AuthController::class, 'logout']);
});