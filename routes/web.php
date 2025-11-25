<?php

use App\Http\Controllers\AdmController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\ClubeController;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\ListaClubeController;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminSistemaController;
use App\Http\Controllers\EsporteController;
use Illuminate\Support\Facades\Route;
use App\Mail\ClubWelcomeEmail;
use App\Mail\UserWelcomeEmail;
use App\Models\Categoria;
use App\Models\Esporte;

/*
|--------------------------------------------------------------------------
| Rotas Web
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('clube')->name('clube.')->group(function () {
    Route::get('/login', function () {
        return view('auth.clube.login');
    })->name('login');

    Route::get('/cadastro', function () {
        return view('auth.clube.register');
    })->name('cadastro');

    Route::get('/dashboard', function () {
        return view('clube.dashboard');
    })->name('dashboard');

    Route::get('/oportunidades', function () {
        return view('clube.oportunidades.index');
    })->name('oportunidades');

    Route::get('/oportunidade', function () {
        return view('clube.oportunidades.show');
    })->name('oportunidade');

    Route::get('/listas', function () {
        return view('clube.listas.index');
    })->name('listas');

    Route::get('/lista', function () {
        return view('clube.listas.show');
    })->name('lista');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', function () {
        return view('auth.admin.login');
    });

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});