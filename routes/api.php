<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthClubeController;
use App\Http\Controllers\ClubeController;
use App\Http\Controllers\PostagemController;

use App\Http\Controllers\AdmController;
use App\Http\Controllers\AdminSistemaController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\SearchUsuarioController;
use App\Http\Controllers\InscricaoOportunidadeController;
use App\Http\Controllers\NotificacoesController;
use App\Http\Controllers\ListaClubeController;
use App\Http\Controllers\MembroClubeController;
use App\Http\Controllers\SeguidorController;
use App\Http\Controllers\perfilController;

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

        // Multiplos perfis
        Route::post('/perfis', [perfilController::class, 'store']);

        // Fim multilpos perfis

        // Postagem protegida
        Route::post('/postagem', [PostagemController::class, 'store']);
        Route::get('/postagem/user/{userId}', [PostagemController::class, 'showUserPosts']); // Rota para pegar posts de um usuário específico

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
    Route::post('/register', [ClubeController::class, 'store']);
    Route::post('/login', [AuthClubeController::class, 'login']);

    Route::middleware('auth:club_sanctum')->group(function () {
        Route::get('/perfil', [AuthClubeController::class, 'perfil']);
        Route::post('/logout', [AuthClubeController::class, 'logout']);

        Route::get('/jogadores', [SearchUsuarioController::class, 'index']); // Rota para buscar jogadores

        Route::get('/minhasOportunidades', [InscricaoOportunidadeController::class, 'myOportunidadesClube']);
        Route::post('/oportunidade', [OportunidadeController::class, 'store']);
        Route::put('/oportunidade/{id}', [OportunidadeController::class, 'update']);
        Route::delete('/oportunidade/{id}', [OportunidadeController::class, 'destroy']);

        Route::get('/oportunidades', [OportunidadeController::class, 'index']);//Tem que retirar essa rota esta mostrando todos 

        // Rotas de inscrições em oportunidades
        Route::get('/oportunidade/{id}/inscritos', [InscricaoOportunidadeController::class, 'inscritosClube']);
        Route::post('/oportunidade/{id}/inscricoes/{usuarioId}/remover', [InscricaoOportunidadeController::class, 'remover']);
        Route::post('/oportunidade/{id}/inscricoes/{usuarioId}/aceitar', [InscricaoOportunidadeController::class, 'aceitar']);

        // Rotas de notificações
        Route::get('/notificacoes', [NotificacoesController::class, 'index']);
        Route::post('notificacao/{id}/ler', [NotificacoesController::class, 'markAsRead']);
        Route::post('notificacoes/ler', [NotificacoesController::class, 'markAllAsRead']);

        // Listas do Clube
        //adicionado por enquanto porque é o unico jeito de puxar as posiçoes e os esportes
         Route::post('/esporte', [AdminSistemaController::class, 'Esportestore']);
        Route::put('/esporte/{id}', [AdminSistemaController::class, 'Esporteupdate']);
        Route::delete('/esporte/{id}', [AdminSistemaController::class, 'Esportedestroy']);
        Route::get('/esporte', [AdminSistemaController::class, 'ListarEsportes']);
        //-------------------------------------------------------------------
         Route::get('/posicao', [AdminSistemaController::class, 'listarPosicoes']);
        Route::post('/posicao', [AdminSistemaController::class, 'storePosicao']);      
        Route::put('/posicao/{id}', [AdminSistemaController::class, 'updatePosicao']);
        Route::delete('/posicao/{id}', [AdminSistemaController::class, 'destroyPosicao']);
       //--------------------------------------------------------------------------
        Route::post('/listas/{listaId}/usuarios', [ListaClubeController::class, 'addUsuarioToLista']);   // add usuário | Qual o caralho da diff desse --Bruno
        Route::delete('/listas/{listaId}/usuarios', [ListaClubeController::class, 'removeUsuarioFromLista']); // remover usuário
        Route::get('/listas', [ListaClubeController::class, 'index']);               // listar todas as listas
        Route::post('/listas', [ListaClubeController::class, 'store']);          // criar nova lista
        Route::put('/listas/{id}', [ListaClubeController::class, 'update']);        // editar lista
        Route::delete('/listas/{id}', [ListaClubeController::class, 'destroy']);     // deletar lista
        Route::post('/listas/{listaId}/usuarios/{usuario}', [ListaClubeController::class, 'addUsuarioToLista']);   // add usuário | e Desse ? --Bruno
        Route::delete('/listas/{listaId}/usuarios/{usuario}', [ListaClubeController::class, 'removeUsuarioFromLista']); // remover usuário
        Route::get('/listas/{id}', [ListaClubeController::class, 'show']);                   // ver lista (com usuários)

        Route::get('/search-usuarios', [SearchUsuarioController::class, 'index']);

        Route::get('/{clubeId}/membros', [MembroClubeController::class, 'listarMembros']);
        Route::post('/{clubeId}/membros/{usuarioId}', [MembroClubeController::class, 'adicionarMembro']);
        Route::delete('/{clubeId}/membros/{usuarioId}', [MembroClubeController::class, 'removerMembro']);
            // Fim Listas do Clube
    
            // Rotas para o clube gerenciar sua conta
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


        // Estas rotas permitem que o admin acesse os métodos 'index'
        Route::get('/usuarios', [UserController::class, 'index']);
        Route::get('/clubes', [ClubeController::class, 'index']);
        Route::get('/oportunidades', [OportunidadeController::class, 'index']);
        Route::get('/list', [AdminSistemaController::class, 'ListOportunidades']);
        Route::get('/oportunidades/pendentes', [AdminSistemaController::class, 'listPending']);
        Route::post('/oportunidades/{id}/aprovar', [AdminSistemaController::class, 'aproved']);
        Route::post('/oportunidades/{id}/recusar', [AdminSistemaController::class, 'reject']);

        // Rotas de gerenciamento
        Route::put('/clube/{id}', [AdminSistemaController::class, 'clubeUpdate']);
        Route::put('/usuario/{id}', [AdminSistemaController::class, 'usuarioUpdate']);
        Route::put('/oportunidade/{id}', [AdminSistemaController::class, 'oportunidadeUpdate']);
        Route::delete('/usuario/{id}', [AdminSistemaController::class, 'UsuarioDestroy']);
        Route::delete('/clube/{id}', [AdminSistemaController::class, 'ClubeDestroy']);
        Route::delete('/oportunidade/{id}', [AdminSistemaController::class, 'OportunidadeDestroy']); 

        Route::post('/esporte', [AdminSistemaController::class, 'Esportestore']);
        Route::put('/esporte/{id}', [AdminSistemaController::class, 'Esporteupdate']);
        Route::delete('/esporte/{id}', [AdminSistemaController::class, 'Esportedestroy']);
        Route::get('/esporte', [AdminSistemaController::class, 'ListarEsportes']);
                                                        // o nome delas estava ao contrario
/*         Route::post('/posicao', [AdminSistemaController::class, 'Posicaostore']);
        Route::put('/posicao/{id}', [AdminSistemaController::class, 'Posicaoupdate']);
        Route::delete('/posicao/{id}', [AdminSistemaController::class, 'Posicaodestroy']); */


        Route::get('/posicao', [AdminSistemaController::class, 'listarPosicoes']);
        Route::post('/posicao', [AdminSistemaController::class, 'storePosicao']);      // Antes era Posicaostore
        Route::put('/posicao/{id}', [AdminSistemaController::class, 'updatePosicao']);    // Antes era Posicaoupdate
        Route::delete('/posicao/{id}', [AdminSistemaController::class, 'destroyPosicao']); // Antes era Posicaodestroy
        
        Route::post('/funcao', [AdminSistemaController::class, 'storeFuncao']);
        Route::put('/funcao/{id}', [AdminSistemaController::class, 'updateFuncao']);
        Route::delete('/funcao/{id}', [AdminSistemaController::class, 'destroyFuncao']);
        Route::get('/funcao', [AdminSistemaController::class, 'listarFuncoes']);
    });
});

//to deixando essas rota aqui por enquanto porque não to conseguindo fazer login
// Rotas do ClubeController
    Route::put('/clube/update-info', [ClubeController::class, 'updateInfo'])->name('clube.updateInfo');
    Route::put('/clube/update-password', [ClubeController::class, 'updatePassword'])->name('clube.updatePassword');

    Route::get('/search-usuarios', [SearchUsuarioController::class, 'index']);

// Route::get('/clube/show', [ClubeController::class, 'show']);
// Route::put('/clube/update/{id}', [ClubeController::class, 'update']);
// Route::delete('/clube/delete/{id}', [ClubeController::class, 'destroy']);

// Rotas protegidas por token - Usuário


// Rotas protegidas por token - Clube
