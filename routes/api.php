<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthClubeController;
use App\Http\Controllers\ClubeController;
use App\Http\Controllers\PostagemController;

use App\Http\Controllers\AdmController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\FuncaoController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\SearchUsuarioController;
use App\Http\Controllers\InscricaoOportunidadeController;
use App\Http\Controllers\NotificacoesController;
use App\Http\Controllers\ListaClubeController;
use App\Http\Controllers\MembroClubeController;
use App\Http\Controllers\SeguidorController;
use App\Http\Controllers\perfilController;
use App\Http\Controllers\EsporteController;

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

    Route::middleware('auth:sanctum,adm_sanctum')->group(function () {
        Route::get('/perfil', [AuthUserController::class, 'perfil']);
        Route::post('/logout', [AuthUserController::class, 'logout']);
        Route::delete('/delete', [AuthUserController::class, 'deleteAccount']);
        Route::put('/update', [AuthUserController::class, 'updateAccount']);

        Route::put('/{id}', [UserController::class, 'update']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::delete('/{id}', [UserController::class, 'destroy']);

        // Multiplos perfis
        Route::post('/perfilStore', [perfilController::class, 'store']);
        Route::get('/perfilForm/{id}', [perfilController::class, 'formInfo']);
        Route::get('/loadPerfilAll', [perfilController::class, 'show']);
        Route::get('/optionsEsportes', [perfilController::class, 'esportesFiltro']);
        Route::put('/perfil/{id}', [PerfilController::class, 'update']);
        Route::delete('/perfil/excluir/{id}', [PerfilController::class, 'destroy']);
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
Route::get('/esporte', [AdmController::class, 'ListarEsportes']);
Route::get('/esporte/{id}/posicoes/', [AdmController::class, 'showPosicoesByEsporte']);

//Clube
Route::prefix('clube')->group(function () {
    Route::post('/register', [ClubeController::class, 'store']);
    Route::post('/login', [AuthClubeController::class, 'login']);

    Route::middleware('auth:club_sanctum,adm_sanctum')->group(function () {
        Route::post('/listas', [ListaClubeController::class, 'store']);       // criar nova lista
        Route::put('/listas/{id}', [ListaClubeController::class, 'update']);        // editar lista
        Route::delete('/listas/{id}', [ListaClubeController::class, 'destroy']);     // deletar lista
        Route::post('/listas/{listaId}/usuarios/{usuario}', [ListaClubeController::class, 'addUsuarioToLista']);   // add usuário | e Desse ? --Bruno
        Route::delete('/listas/{listaId}/usuarios/{usuario}', [ListaClubeController::class, 'removeUsuarioFromLista']); // remover usuário
        Route::get('/listas/{id}', [ListaClubeController::class, 'show']);                   // ver lista (com usuários)
        Route::post('/listas/{listaId}/usuarios', [ListaClubeController::class, 'addUsuarioToLista']);   // add usuário | Qual o caralho da diff desse --Bruno
        Route::delete('/listas/{listaId}/usuarios', [ListaClubeController::class, 'removeUsuarioFromLista']); // remover usuário
        Route::get('/listas', [ListaClubeController::class, 'index']);               // listar todas as listas

        // Rotas de clubes protegidas
        Route::put('/{id}', [ClubeController::class, 'update']);
        Route::get('/{id}', [ClubeController::class, 'show']);
        Route::delete('/{id}', [ClubeController::class, 'destroy']);

        Route::get('/perfil', [AuthClubeController::class, 'perfil']);
        Route::post('/logout', [AuthClubeController::class, 'logout']);

        Route::get('/jogadores', [SearchUsuarioController::class, 'index']); // Rota para buscar jogadores

        Route::get('/minhasOportunidades', [InscricaoOportunidadeController::class, 'myOportunidadesClube']);
        Route::get('/oportunidade/{id}', [OportunidadeController::class, 'show']);
        Route::post('/oportunidade', [OportunidadeController::class, 'store']);
        Route::put('/oportunidade/{id}', [OportunidadeController::class, 'update']);
        Route::delete('/oportunidade/{id}', [OportunidadeController::class, 'destroy']);

        Route::get('/oportunidades', [OportunidadeController::class, 'index']); //Tem que retirar essa rota esta mostrando todos 

        // Rotas de inscrições em oportunidades
        Route::get('/oportunidade/{id}/inscritos', [InscricaoOportunidadeController::class, 'inscritosClube']);
        Route::delete('/oportunidade/{id}/inscricoes/{usuarioId}', [InscricaoOportunidadeController::class, 'remover']);

        // Rotas de notificações
        Route::get('/notificacoes', [NotificacoesController::class, 'index']);
        Route::post('notificacao/{id}/ler', [NotificacoesController::class, 'markAsRead']);
        Route::post('notificacoes/ler', [NotificacoesController::class, 'markAllAsRead']);

        // Listas do Clube
        //adicionado por enquanto porque é o unico jeito de puxar as posiçoes e os esportes
        Route::post('/esporte', [AdmController::class, 'Esportestore']);
        Route::put('/esporte/{id}', [AdmController::class, 'Esporteupdate']);
        Route::delete('/esporte/{id}', [AdmController::class, 'Esportedestroy']);
        //-------------------------------------------------------------------
        Route::get('/posicao', [AdmController::class, 'listarPosicoes']);
        Route::post('/posicao', [AdmController::class, 'storePosicao']);
        Route::put('/posicao/{id}', [AdmController::class, 'updatePosicao']);
        Route::delete('/posicao/{id}', [AdmController::class, 'destroyPosicao']);
        //--------------------------------------------------------------------------

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
        Route::put('/perfil/identidade', [AdminProfileController::class, 'updateIdentidade']);
        Route::put('/perfil/informacoes', [AdminProfileController::class, 'updateInformacoes']);

        // Adição de clube via adm
        Route::post('/clube', [ClubeController::class, 'storeByAdmin']);
        Route::post('/usuario', [UserController::class, 'storeByAdmin']);

        // Estas rotas permitem que o admin acesse os métodos 'index'
        Route::get('/usuarios', [UserController::class, 'index']);
        Route::get('/clubes', [ClubeController::class, 'index']);

        Route::get('/oportunidades', [OportunidadeController::class, 'index']);
        Route::get('/oportunidades/pendentes', [AdmController::class, 'listPending']);
        Route::put('/oportunidade/{oportunidade}/status', [AdmController::class, 'oportunidadeUpdateStatus']);
        Route::get('/oportunidade/{id}', [OportunidadeController::class, 'show']);

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
        Route::get('/esporte/{id}', [AdmController::class, 'ListarEsportesId']);
        Route::get('/esporte/{id}/posicoes/', [AdmController::class, 'showPosicoesByEsporte']);

                                                        // o nome delas estava ao contrario
/*         Route::post('/posicao', [AdmController::class, 'Posicaostore']);
        Route::put('/posicao/{id}', [AdmController::class, 'Posicaoupdate']);
        Route::delete('/posicao/{id}', [AdmController::class, 'Posicaodestroy']); */


        Route::get('/posicao', [AdmController::class, 'listarPosicoes']);
        Route::get('/posicao/{id}', [AdmController::class, 'listarPosicoesId']);
        Route::post('/posicao', [AdmController::class, 'storePosicao']);      // Antes era Posicaostore
        Route::put('/posicao/{id}', [AdmController::class, 'updatePosicao']);    // Antes era Posicaoupdate
        Route::delete('/posicao/{id}', [AdmController::class, 'destroyPosicao']); // Antes era Posicaodestroy

        Route::get('/caracteristica/{id}', [AdmController::class, 'listarCaracteristicasId']);
        Route::post('/caracteristica', [AdmController::class, 'storeCaracteristica']);
        Route::put('/caracteristica/{id}', [AdmController::class, 'updateCaracteristica']);
        Route::delete('/caracteristica/{id}', [AdmController::class, 'destroyCaracteristica']);
        
        Route::post('/funcao', [FuncaoController::class, 'store']);
        Route::put('/funcao/{id}', [FuncaoController::class, 'update']);
        Route::delete('/funcao/{id}', [FuncaoController::class, 'destroy']);
        Route::get('/funcao', [FuncaoController::class, 'index']);
        Route::get('/funcao/{id}', [FuncaoController::class, 'show']);

        Route::delete('/listas/{id}', [ListaClubeController::class, 'destroy']);
        Route::get('/listas/{id}', [ListaClubeController::class, 'show']);
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
