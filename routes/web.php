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

 Route::get('/sidebar', function () {
            return view('admin.sidebar.sidebar-adm');
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


Route::get('/testes/topbar', function () {
    return view('area-51.topbar');
});

Route::get('/testes/empty-state', function () {
    return view('area-51.empty-state');
});

Route::get('/testes/pagination', function () {
    return view('area-51.pagination');
});

Route::get('/testes/tables', function () {
    return view('area-51.tables');
});

Route::get('/testes/layout-clube', function () {
    return view('area-51.layout-clube');
});

Route::get('/testes/oportunidades-clube', function () {
    return view('area-51.oportunidades-clube');
});

Route::get('/testes/oportunidade', function () {
    return view('area-51.oportunidade');
});

Route::get('/testes/layout-admin', function () {
    return view('area-51.layout-admin');
});

Route::get('/testes/login-clube', function () {
    return view('area-51.login-clube');
});

Route::get('/testes/cadastro-clube', function () {
    return view('area-51.cadastro-clube');
});

Route::get('/testes/login-admin', function () {
    return view('area-51.login-admin');
});

Route::get('/testes/badges', function () {
    return view('area-51.badges');
});