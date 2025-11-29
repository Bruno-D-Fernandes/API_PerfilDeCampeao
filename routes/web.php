<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\ClubeController;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\ListaClubeController;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminSistemaController;
use App\Http\Controllers\EsporteController;
use App\Http\Controllers\DashClubeController;
use App\Http\Controllers\AuthClubeController;
use App\Http\Controllers\AuthAdmController;
use App\Http\Controllers\DashAdminController;
use App\Http\Controllers\EventoClubeController;
use App\Mail\ClubWelcomeEmail;
use App\Mail\UserWelcomeEmail;
use App\Models\Categoria;
use App\Models\Esporte;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('clube')->name('clube.')->group(function () {
    Route::get('/login', [AuthClubeController::class, 'showLoginForm'])->name('login');

    Route::post('/login', [AuthClubeController::class, 'login'])->name('login.submit');
    
    Route::get('/cadastro', [AuthClubeController::class, 'showRegisterForm'])->name('cadastro');
    
    Route::post('/cadastro', [AuthClubeController::class, 'register'])->name('cadastro.submit');

    Route::middleware(['auth:club'])->group(function () {
        Route::post('/logout', [AuthClubeController::class, 'logout'])->name('logout');
       
        Route::get('/dashboard', [DashClubeController::class, 'dashboardData'])->name('dashboard');

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

        Route::get('/perfil', function () {
            return view('clube.perfil');
        })->name('perfil');

        Route::get('/mensagens', function () {
            return view('clube.mensagens');
        })->name('mensagens');

        Route::get('/agenda', [EventoClubeController::class, 'calendar'])->name('agenda');

        Route::get('/pesquisa', function () {
            return view('clube.pesquisa');
        })->name('pesquisa');

        Route::get('/configuracoes', function () {
            return view('clube.configuracoes');
        })->name('configuracoes');

        
        Route::get('/ajax/calendar-grid', [EventoClubeController::class, 'calendar'])
            ->name('ajax.calendar');

        Route::get('/ajax/day-details', function () {
            $date = request()->query('date');
            
            $eventos = [];
            
            $dia = \Carbon\Carbon::parse($date)->day;
            if ($dia == 5) {
                $eventos[] = ['titulo' => 'Treino Tático', 'color' => '#22c55e', 'hora_inicio' => '14:00', 'hora_fim' => '16:00', 'descricao' => 'Treino principal'];
            }
            if ($dia == 12) {
                $eventos[] = ['titulo' => 'Final Regional', 'color' => '#ef4444', 'hora_inicio' => '09:00', 'hora_fim' => '12:00'];
                $eventos[] = ['titulo' => 'Fisioterapia', 'color' => '#3b82f6', 'hora_inicio' => '14:00', 'hora_fim' => '15:00'];
            }

            return view('clube.partials.day-events-list', compact('eventos'));
        })->name('ajax.day-details');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthAdmController::class, 'showLoginForm'])->name('login');

    Route::post('/login', [AuthAdmController::class, 'loginAdm'])->name('login.submit');

    Route::post('/logout', [AuthAdmController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashAdminController::class, 'dashboardData'])->name('dashboard');

    Route::get('/funcoes', function () {
        return view('admin.funcoes.index');
    })->name('funcoes');
});

Route::get('/usuario/perfil', function () {
    return view('clube.usuarios.show');
})->name('usuario.perfil');