<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\webController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// routes/web.php

Route::get('/perfil', function () {
    return view('perfil');
})->name('perfil');

Route::get('/login', function () {
    return view('login'); 
})->name('login');

Route::get('/registro', function () {
    return view('registro');
})->name('registro');





