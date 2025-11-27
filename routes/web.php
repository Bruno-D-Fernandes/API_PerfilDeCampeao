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

        Route::get('/agenda', function () {
            return view('clube.agenda');
        })->name('agenda');

        Route::get('/pesquisa', function () {
            return view('clube.pesquisa');
        })->name('pesquisa');

        Route::get('/configuracoes', function () {
            return view('clube.configuracoes');
        })->name('configuracoes');
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

Route::get('/ajax/calendar-grid', function () {
    $mes = request()->query('month', now()->month);
    $ano = request()->query('year', now()->year);
    $selectedDateStr = request()->query('date', now()->format('Y-m-d'));

    $dataVisualizada = Carbon::create($ano, $mes, 1);
    $primeiroDiaSemana = $dataVisualizada->dayOfWeek; 
    $colStart = $primeiroDiaSemana + 1; 
    $totalDiasNoMes = $dataVisualizada->daysInMonth;

    $dias = [];
    for ($i = 1; $i <= $totalDiasNoMes; $i++) {
        $currentDateObj = Carbon::create($ano, $mes, $i);
        $currentDateStr = $currentDateObj->format('Y-m-d');
        $listaEventos = [];

        if ($i == 5) $listaEventos[] = ['titulo' => 'Treino Tático', 'color' => '#22c55e'];

        if ($i == 12) {
            $listaEventos[] = ['titulo' => 'Final Regional', 'color' => '#ef4444'];
            $listaEventos[] = ['titulo' => 'Fisioterapia', 'color' => '#3b82f6'];
        }

        if ($i == 20) {
            $listaEventos[] = ['titulo' => 'Reunião Diretoria', 'color' => '#eab308'];
            $listaEventos[] = ['titulo' => 'Peneira Sub-15', 'color' => '#a855f7'];
        }

        $dias[] = [
            'numero' => $i,
            'full_date' => $currentDateStr,
            'is_today' => $currentDateObj->isToday(),
            'eventos' => $listaEventos
        ];
    }

    $maxEventos = 2;

    return view('clube.partials.calendar-grid', compact('dias', 'colStart', 'maxEventos'));
})->name('clube.ajax.calendar');

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
})->name('clube.ajax.day-details');