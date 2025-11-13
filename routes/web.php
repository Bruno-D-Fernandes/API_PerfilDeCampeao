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

Route::prefix('clube')->group(function () {
    Route::get('/login', function () {
        return view('clube.login');
    })->name('clube.login');

    Route::get('/cadastro', function () {
        return view('clube.cadastro')->with([
            'categorias' => Categoria::all(), 
            'esportes' => Esporte::all()
        ]);
    })->name('clube-cadastro');

    Route::get('/dashboard', function () {
        return view('clube.dashboard');
    })->name('clube-dashboard');

    Route::get('/configuracoes', function () {
        return view('clube.configuracoes.configuracoes'); 
    })->name('clube-configuracoes');

    Route::get('/oportunidades', function () {
        return view('clube.oportunidades.oportunidades'); 
    })->name('clube-oportunidades');

    Route::get('/pesquisa', function () {
        return view('clube.pesquisa.pesquisa'); 
    })->name('clube-pesquisa');


    Route::get('/{id}', [ClubeController::class, 'showProfilePage'])->name('clube-perfil'); 
});

Route::prefix('admin')->group(function () {
    Route::get('/login', function () {
        return view('admin.login');
    })->name('admin.login');

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin-dashboard');

    Route::prefix('configuracoes')->group(function () {

        Route::get('/perfil', [AdmController::class, 'showProfilePage'])->name('admin-config-perfil');


        Route::get('/layout', function () {
            return view('admin.config.layout');
        })->name('admin-config-layout');

        Route::get('/backup', function () {
            return view('admin.configuracoes.backup');
        })->name('admin-config-backup');

        Route::get('/notificacoes', function () {
            return view('admin.configuracoes.notificacoes');
        })->name('admin-config-notificacoes');

        Route::get('/sobre', function () {
            return view('admin.configuracoes.sobre');
        })->name('admin-config-sobre');

        Route::get('/tema', function () {
            return view('admin.configuracoes.tema');
        })->name('admin-config-tema');
    });

    Route::get('/esportes', [EsporteController::class, 'showWebPage'])->name('admin-esportes'); 

    Route::get('/funcoes', [FuncaoController::class, 'showWebPage'])->name('admin-funcoes');

    Route::get('/listas', [ListaClubeController::class, 'showWebPage'])->name('admin-listas');

    Route::get('/clubes', [ClubeController::class, 'showWebPage'])->name('admin-clubes'); 

    Route::get('/usuarios', [UserController::class, 'showWebPage'])->name('admin-usuarios');
    
    Route::get('/oportunidades', [OportunidadeController::class, 'showWebPage'])->name('admin-oportunidades'); 

    Route::get('/perfil', [AdminProfileController::class, 'showProfilePage'])->name('admin-perfil');
});

Route::get('/usuarios/{id}', [UserController::class, 'showProfilePage'])->name('usuarios');
