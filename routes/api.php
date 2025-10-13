<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthClubeController;
use App\Http\Controllers\clubeController;
use App\Http\Controllers\PostagemController;
use App\Http\Controllers\AdmController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\SearchUsuarioController;
use App\Http\Controllers\InscricaoOportunidadeController;
use App\Http\Controllers\NotificacoesController;
use App\Http\Controllers\ListaClubeController;
use App\Http\Controllers\SeguidorController;

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

// Usuario
Route::prefix('usuario')->group(function () {
    Route::post('/register', [UserController::class, 'store']);
    Route::post('/login', [AuthUserController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/perfil', [AuthUserController::class, 'perfil']);
        Route::post('/logout', [AuthUserController::class, 'logout']);
        Route::delete('/delete', [AuthUserController::class, 'deleteAccount']);
        Route::put('/update', [AuthUserController::class, 'updateAccount']);

        // Postagem protegida
        Route::post('/postagem', [PostagemController::class, 'store']);

        // Seguir e deixar de seguir protegidos
        Route::post('/{id}/seguir', [SeguidorController::class, 'seguirUsuario']);
        Route::post('/{id}/deixar-de-seguir', [SeguidorController::class, 'deixarDeSeguirUsuario']);

        Route::get('/seguidores', [SeguidorController::class, 'getSeguidores']);
        Route::get('/seguindo', [SeguidorController::class, 'getSeguindo']);
        Route::get('/amigos', [SeguidorController::class, 'getAmigos']);
        Route::get('/sugestoes', [SeguidorController::class, 'getSugestoes']);

        Route::put('/postagem/{id}', [PostagemController::class, 'update']);
        Route::delete('/postagem/{id}', [PostagemController::class, 'destroy']);

        // Rotas de inscrições em oportunidades
        Route::get('/oportunidades', [OportunidadeController::class, 'index']);
        Route::get('/oportunidade/{id}', [OportunidadeController::class, 'show']);


        Route::post('/oportunidades/{id}/inscrever', [InscricaoOportunidadeController::class, 'store']);
        Route::get('/inscricoes', [InscricaoOportunidadeController::class, 'myOportunidadesUsuario']);
        Route::delete('/oportunidades/{id}/inscricao', [InscricaoOportunidadeController::class, 'cancelar']);

        // Rotas de notificações
        Route::get('/notificacoes', [NotificacoesController::class, 'index']);
        Route::post('notificacao/{id}/ler', [NotificacoesController::class, 'markAsRead']);
        Route::post('notificacoes/ler', [NotificacoesController::class, 'markAllAsRead']);
    });
});

// Postagem pública (index, show)
Route::get('/postagem', [PostagemController::class, 'index']);
Route::get('/postagem/{id}', [PostagemController::class, 'show']);


//Clube
Route::prefix('clube')->group(function () {
    Route::post('/register', [clubeController::class, 'store']);
    Route::post('/login', [AuthClubeController::class, 'loginClube']);

    Route::middleware('auth:club_sanctum')->group(function () {
        Route::get('/perfil', [AuthClubeController::class, 'perfil']);
        Route::post('/logout', [AuthClubeController::class, 'logout']);

        Route::get('/jogadores', [SearchUsuarioController::class, 'index']); // Rota para buscar jogadores

        Route::get('/minhasOportunidades', [InscricaoOportunidadeController::class, 'myOportunidadesClube']);
        Route::post('/oportunidade', [OportunidadeController::class, 'store']);
        Route::put('/oportunidade/{id}', [OportunidadeController::class, 'update']);
        Route::delete('/oportunidade/{id}', [OportunidadeController::class, 'destroy']);

        // Rotas de inscrições em oportunidades
        Route::get('/oportunidade/{id}/inscritos', [InscricaoOportunidadeController::class, 'inscritosClube']);
        Route::delete('/oportunidade/{id}/inscricoes/{usuarioId}', [InscricaoOportunidadeController::class, 'remover']);

        // Rotas de notificações
        Route::get('/notificacoes', [NotificacoesController::class, 'index']);
        Route::post('notificacao/{id}/ler', [NotificacoesController::class, 'markAsRead']);
        Route::post('notificacoes/ler', [NotificacoesController::class, 'markAllAsRead']);

        // Listas do Clube
        Route::get('/listas', [ListaClubeController::class, 'index']);               // listar todas as listas
        Route::post('/listas', [ListaClubeController::class, 'store']);          // criar nova lista
        Route::put('/listas/{id}', [ListaClubeController::class, 'update']);        // editar lista
        Route::delete('/listas/{id}', [ListaClubeController::class, 'destroy']);     // deletar lista
        Route::post('/listas/{listaId}/usuarios/{usuario}', [ListaClubeController::class, 'addUsuarioToLista']);   // add usuário
        Route::delete('/listas/{listaId}/usuarios/{usuario}', [ListaClubeController::class, 'removeUsuarioFromLista']); // remover usuário
        Route::get('/listas/{id}', [ListaClubeController::class, 'show']);                   // ver lista (com usuários)

        Route::get('/search-usuarios', [SearchUsuarioController::class, 'index']);

        Route::put('/update', [AuthClubeController::class, 'updateAccount']);
        Route::delete('/delete', [AuthClubeController::class, 'deleteAccount']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        // Seguir e deixar de seguir clube protegidos
        Route::post('/{id}/seguir', [SeguidorController::class, 'seguirClube']);
        Route::post('/{id}/deixar-de-seguir', [SeguidorController::class, 'deixarDeSeguirClube']);
    });
});

//Admin
Route::prefix('admin')->group(function () {
    Route::post('/login', [AdmController::class, 'loginAdm']);
    Route::middleware('auth:adm_sanctum')->group(function () {
        Route::get('/perfil', [AdmController::class, 'perfilAdm']);
        Route::post('/logout', [AdmController::class, 'logoutAdm']);

        Route::get('/oportunidades/pendentes', [AdmController::class, 'listPending']);
        Route::post('/oportunidades/{id}/aprovar', [AdmController::class, 'aproved']);
        Route::post('/oportunidades/{id}/recusar', [AdmController::class, 'rejected']);

        // Rotas de gerenciamento
        Route::put('/clube/{id}', [AdmController::class, 'clubeUpdate']);
        Route::put('/usuario/{id}', [AdmController::class, 'usuarioUpdate']);
        Route::put('/oportunidade/{id}', [AdmController::class, 'oportunidadeUpdate']);
        Route::delete('/usuario/{id}', [AdmController::class, 'UsuarioDestroy']);
        Route::delete('/clube/{id}', [AdmController::class, 'ClubeDestroy']);
        Route::delete('/oportunidade/{id}', [AdmController::class, 'OportunidadeDestroy']); 

        Route::post('/esporte', [AdmController::class, 'Esportestore']);
        Route::put('/esporte/{id}', [AdmController::class, 'Esporteupdate']);
        Route::delete('/esporte/{id}', [AdmController::class, 'Esportedestroy']);
        Route::get('/esporte', [AdmController::class, 'ListarEsportes']);

        Route::post('/posicao', [AdmController::class, 'storePosicao']);
        Route::put('/posicao/{id}', [AdmController::class, 'Posicaoupdate']);
        Route::delete('/posicao/{id}', [AdmController::class, 'Posicaodestroy']);
        Route::get('/posicao', [AdmController::class, 'ListarPosicoes']);

        Route::post('/categoria', [AdmController::class, 'Categoriastore']);
        Route::put('/categoria/{id}', [AdmController::class, 'Categoriaupdate']);
        Route::delete('/categoria/{id}', [AdmController::class, 'Categoriadestroy']);
        Route::get('/categoria', [AdmController::class, 'ListarCategorias']);
    });
});

//to deixando essas rota aqui por enquanto porque não to conseguindo fazer login
// Rotas do ClubeController
    Route::put('/clube/update-info', [ClubeController::class, 'updateInfo'])->name('clube.updateInfo');
    Route::put('/clube/update-password', [ClubeController::class, 'updatePassword'])->name('clube.updatePassword');

    Route::get('/search-usuarios', [SearchUsuarioController::class, 'index']);

Route::post('/api/oportunidades', [OportunidadeController::class, 'store'])
        ->name('api.oportunidades.store');

    Route::get('/api/oportunidades/{id}', [OportunidadeController::class, 'show'])
        ->name('api.oportunidades.show');
// Route::get('/clube/show', [ClubeController::class, 'show']);
// Route::put('/clube/update/{id}', [ClubeController::class, 'update']);
// Route::delete('/clube/delete/{id}', [ClubeController::class, 'destroy']);

// Rotas protegidas por token - Usuário


// Rotas protegidas por token - Clube
