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
use App\Http\Controllers\AdminOportunidadesController;
use App\Http\Controllers\DashClubeController;
use App\Http\Controllers\AuthClubeController;
use App\Http\Controllers\AuthAdmController;
use App\Http\Controllers\ClubeOportunidadeController;
use App\Http\Controllers\DashAdminController;
use App\Http\Controllers\EventoClubeController;
use App\Http\Controllers\SearchUsuarioController;
use App\Http\Controllers\ClubeChatController;
use App\Http\Controllers\ChatController;
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
    
    Route::post('/clube/register', [ClubeController::class, 'store'])->name('cadastro.submit');

    Route::middleware(['auth:club'])->group(function () {
        Route::post('/logout', [AuthClubeController::class, 'logout'])->name('logout');
       
        Route::get('/dashboard', [DashClubeController::class, 'index'])->name('dashboard');

        Route::get('/dashboard/content/{esporteId}', [DashClubeController::class, 'loadContent'])->name('clube.dashboard.content');

        Route::get('/minhas-oportunidades', [ClubeOportunidadeController::class, 'index'])
        ->name('minhas-oportunidades');

        Route::get('/minhas-oportunidades/{id}', [ClubeOportunidadeController::class, 'show'])
        ->name('oportunidades.show');

        Route::get('/listas', function () {
            return view('clube.listas.index');
        })->name('listas');

        Route::get('/listas/{id}', [ListaClubeController::class, 'show'])
        ->name('listas.show');

        Route::get('/mensagens', [ClubeChatController::class, 'index'])->name('mensagens');

        Route::get('/mensagens/conversas', [ClubeChatController::class, 'conversations'])->name('mensagens.conversas');

        Route::get('/mensagens/{conversation}/messages', [ClubeChatController::class, 'messages'])->name('mensagens.messages');

        Route::post('/mensagens/send', [ChatController::class, 'sendMessage'])->name('mensagens.send');
        
        Route::post('/mensagens/send-invite', [ChatController::class, 'sendEventInvite'])->name('mensagens.sendInvite');

        Route::get('/agenda', [EventoClubeController::class, 'calendar'])->name('agenda');

        Route::get('/pesquisa', [SearchUsuarioController::class, 'showPage'])
            ->name('pesquisa');

        Route::get('/pesquisa/data', [SearchUsuarioController::class, 'index'])->name('pesquisa.data');

        Route::get('/configuracoes', function () {
            return view('clube.configuracoes');
        })->name('configuracoes');

        Route::get('/ajax/calendar-grid', [EventoClubeController::class, 'calendar'])
            ->name('ajax.calendar');

        Route::get('/ajax/day-details', [EventoClubeController::class, 'dayDetails'])
        ->name('ajax.day-details');

        Route::get('/ajax/next-events', [EventoClubeController::class, 'nextEventsHtml'])
        ->name('ajax.next-events');

        Route::get('/{id}', [ClubeController::class, 'showProfilePage'])
        ->where('id', '[0-9]+')
        ->name('perfil');
    });
});

Route::middleware(['auth:club'])->group(function () {
    Route::get('/usuario/{id}', [UserController::class, 'showProfilePage'])
        ->where('id', '[0-9]+')
        ->name('usuarios.perfil');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthAdmController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthAdmController::class, 'loginAdm'])->name('login.submit');
    Route::post('/logout', [AuthAdmController::class, 'logout'])->name('logout');

    // página web (Blade)
    Route::get('/dashboard', [DashAdminController::class, 'dashboardData'])->name('dashboard');
    Route::post('/dashboard/oportunidades/aprovar', [DashAdminController::class, 'approveOpportunity'])
    ->name('oportunidades.aprovar');

Route::post('/dashboard/oportunidades/recusar', [DashAdminController::class, 'rejectOpportunity'])
    ->name('oportunidades.recusar');

    Route::get('/oportunidades', [AdminOportunidadesController::class, 'index'])->name('oportunidades');

    Route::post('/clube/aprovar', [DashAdminController::class, 'clubesAprovar'])->name('clube.aprovar');


    // rotas JSON que o Alpine usa
    Route::prefix('oportunidades-json')->group(function () {
        Route::get('/metrics', [AdminOportunidadesController::class, 'metrics'])->name('oportunidades.metrics');
        Route::get('/list', [AdminOportunidadesController::class, 'list'])->name('oportunidades.list');
        Route::get('/{oportunidade}/inscritos', [AdminOportunidadesController::class, 'listInscricoes'])->name('oportunidades.inscritos');
        Route::put('/{oportunidade}', [AdminOportunidadesController::class, 'update'])->name('oportunidades.update');
        Route::put('/{oportunidade}/status', [AdminOportunidadesController::class, 'updateStatus'])->name('oportunidades.updateStatus');
        Route::delete('/{oportunidade}', [AdminOportunidadesController::class, 'destroy'])->name('oportunidades.destroy');
    });

    Route::get('/funcoes', function () {
        return view('admin.funcoes.index');
    })->name('funcoes');
});
