<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\AuthClubeController;
use App\Http\Controllers\ClubeController;
use App\Http\Controllers\PostagemController;
use App\Http\Controllers\DashAdminController;
use App\Http\Controllers\DashClubeController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConviteEventoController;
use App\Http\Controllers\EventoClubeController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\FuncaoController;
use App\Http\Controllers\AdminSistemaController;
use App\Http\Controllers\AdminEventoController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\OportunidadeController;
use App\Http\Controllers\SearchUsuarioController;
use App\Http\Controllers\InscricaoOportunidadeController;
use App\Http\Controllers\NotificacoesController;
use App\Http\Controllers\AdminOportunidadesController;
use App\Http\Controllers\ListaClubeController;
use App\Http\Controllers\MembroClubeController;
use App\Http\Controllers\SeguidorController;
use App\Http\Controllers\perfilController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ClubeChatController;
use App\Http\Controllers\ClubeOportunidadeController;
use App\Models\Clube;
use App\Models\Usuario;
use Laravel\Sanctum\Sanctum;

// Usuario
Route::prefix('usuario')->group(function () {
    Route::post('/register', [UserController::class, 'store']);
    Route::post('/login', [AuthUserController::class, 'login']);

    Route::middleware('auth:sanctum,adm_sanctum')->group(function () {
        Route::get('/perfil', [AuthUserController::class, 'perfil']);
        Route::post('/logout', [AuthUserController::class, 'logout']);
        Route::delete('/delete', [AuthUserController::class, 'deleteAccount']);
        Route::put('/update', [AuthUserController::class, 'updateAccount']);


        // Multiplos perfis
        Route::post('/perfilStore', [perfilController::class, 'store']);
        Route::get('/perfilForm/{id}', [perfilController::class, 'formInfo']);
        Route::get('/loadPerfilAll', [perfilController::class, 'show']);
        Route::get('/optionsEsportes', [perfilController::class, 'esportesFiltro']);
        Route::put('/perfil/{id}', [PerfilController::class, 'update']);
        Route::delete('/perfil/excluir/{id}', [PerfilController::class, 'destroy']);
        Route::get('/hasPerfil', [PerfilController::class, 'hasPerfil']);
        // Fim multilpos perfis

        //Eventos 
        Route::get('/eventos', [EventoClubeController::class, 'listUserEvents']);

        // Postagem protegida
        Route::post('/postagem', [PostagemController::class, 'store']);
        Route::get('/postagem/user/{userId}/{esporteId}', [PostagemController::class, 'showUserPosts']);


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
        Route::get('/oportunidades/filtrar', [OportunidadeController::class, 'filtrar']);
        Route::get('/oportunidade/{id}', [OportunidadeController::class, 'show']);

        Route::post('/oportunidades/{id}/inscrever', [InscricaoOportunidadeController::class, 'store']);
        Route::get('/inscricoes', [InscricaoOportunidadeController::class, 'myOportunidadesUsuario']);
        Route::delete('/oportunidades/{id}/inscricao', [InscricaoOportunidadeController::class, 'cancelar']);

        // Rotas de notificações
        Route::get('/notificacoes', [NotificacoesController::class, 'index']);
        Route::post('notificacao/{id}/ler', [NotificacoesController::class, 'markAsRead']);
        Route::post('notificacoes/ler', [NotificacoesController::class, 'markAllAsRead']);

        Route::get('/show/{id}', [UserController::class, 'show']);
        Route::put('/update/{id}', [UserController::class, 'update']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
        Route::post('/logout', [AuthUserController::class, 'logout']);

        // Convites de eventos (usuário)
        Route::get('/convites/pendentes', [ConviteEventoController::class, 'pendentes']);
        Route::get('/convites/aceitos', [ConviteEventoController::class, 'aceitos']);
        Route::get('/convites/expirados', [ConviteEventoController::class, 'expirados']);
        Route::get('/convites/cancelados-pelo-clube', [ConviteEventoController::class, 'canceladosPeloClube']);

        // Calendário (agendamentos = convites aceitos)
        Route::get('/agenda/calendar', [ConviteEventoController::class, 'calendar']);
        Route::put('/convites/{conviteId}/cor', [ConviteEventoController::class, 'updateColor']);


        Route::get('clube/{id}', [ClubeController::class, 'show']);


        // Usuário aceita um convite (usado pelo botão "Aceitar" no chat)
        Route::post('/convites/{conviteId}/aceitar', [ChatController::class, 'aceitoInvite']);
    });
});

// Postagem pública (index, show)
Route::get('/postagem', [PostagemController::class, 'index']);
Route::get('/postagem/{id}', [PostagemController::class, 'show']);

//Clube
Route::prefix('clube')->group(function () {
    Route::post('/register', [ClubeController::class, 'store']);
    Route::post('/login', [AuthClubeController::class, 'login']);

    Route::middleware(['web', 'auth:club_sanctum,adm_sanctum'])->group(function () {
        Route::put('/update', [AuthClubeController::class, 'updateAccount']);

        Route::get('/perfil', [AuthClubeController::class, 'perfil']);
        Route::post('/logout', [AuthClubeController::class, 'logout']);

        Route::get('/jogadores', [SearchUsuarioController::class, 'index']); // Rota para buscar jogadores

        Route::get('/listas', [ListaClubeController::class, 'index']);               // listar todas as listas
        Route::post('/listas', [ListaClubeController::class, 'store']);
        Route::get('/listas/{id}', [ListaClubeController::class, 'show']);                   // ver lista (com usuários)
        Route::put('/listas/{id}', [ListaClubeController::class, 'update']);        // editar lista
        Route::delete('/listas/{id}', [ListaClubeController::class, 'destroy']);     // deletar lista
        Route::get('/listas/{id}/usuarios/search', [ListaClubeController::class, 'searchUsuarios']);
        Route::post('/listas/{listaId}/usuarios/{usuario}', [ListaClubeController::class, 'addUsuarioToLista']);   // add usuário | e Desse ? --Bruno
        Route::delete('/listas/{listaId}/usuarios/{usuario}', [ListaClubeController::class, 'removeUsuarioFromLista']); // remover usuário

        Route::get('/minhasOportunidades', [InscricaoOportunidadeController::class, 'myOportunidadesClube']);
        Route::get('/oportunidade/{id}', [OportunidadeController::class, 'show']);
        Route::post('/oportunidade', [OportunidadeController::class, 'store']);
        Route::put('/oportunidade/{id}', [OportunidadeController::class, 'update']);
        Route::delete('/oportunidade/{id}', [OportunidadeController::class, 'destroy']);
        Route::get('/oportunidade/{id}/inscricoes/search', [ClubeOportunidadeController::class, 'searchInscricoes']);

        Route::post('/oportunidade-painel', [ClubeOportunidadeController::class, 'store']);
        Route::put('/oportunidade-painel/{id}', [ClubeOportunidadeController::class, 'update']);
        Route::delete('/oportunidade-painel/{id}', [ClubeOportunidadeController::class, 'destroy']);

        Route::get('/oportunidades', [OportunidadeController::class, 'index']); //Tem que retirar essa rota esta mostrando todos 

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
        //-------------------------------------------------------------------------

        Route::get('/search-usuarios', [SearchUsuarioController::class, 'index']);

        Route::get('/{clubeId}/membros', [MembroClubeController::class, 'listarMembros']);
        Route::post('/{clubeId}/membros/{usuarioId}', [MembroClubeController::class, 'adicionarMembro']);
        Route::delete('/{clubeId}/membros/{usuarioId}', [MembroClubeController::class, 'removerMembro']);

        // Dashboard Clube - resumo geral
        Route::get('/dashboard/resumo-geral', [DashClubeController::class, 'resumoGeral']);

        // Dashboard Clube - distribuição por posições (filtra por ?esporte_id=)
        Route::get('/dashboard/distribuicao-posicoes', [DashClubeController::class, 'distribuicaoPosicoes']);

        // Dashboard Clube - evolução mensal de inscrições (filtra por ?esporte_id= & ?months=)
        Route::get('/dashboard/inscricoes-mensais', [DashClubeController::class, 'inscricoesMensais']);

        // Dashboard Clube - top 5 estados com mais inscritos (filtra por ?esporte_id=)
        Route::get('/dashboard/top-estados-inscricoes', [DashClubeController::class, 'topEstadosInscricoes']);

        // Dashboard Clube - atividades recentes (oportunidades + inscrições)
        Route::get('/dashboard/atividades-recentes', [DashClubeController::class, 'atividadesRecentes']);

        //Seja feliz João --Luan
        // Fim Listas do Clube
        // Eventos do clube
        Route::get('/agenda/calendar', [EventoClubeController::class, 'calendar']);

        Route::get('/eventos', [EventoClubeController::class, 'listEventsClube']);
        Route::post('/eventos', [EventoClubeController::class, 'criarEvento']);
        Route::get('/eventos/{eventoId}', [EventoClubeController::class, 'detalhesEvento']);
        Route::put('/eventos/{eventoId}', [EventoClubeController::class, 'atualizarEvento']);
        Route::delete('/eventos/{eventoId}', [EventoClubeController::class, 'deletarEvento']);

        // Convites de um evento específico (ver quem está pendente/aceito/expirado/cancelado)
        Route::get('/eventos/{eventoId}/convites', [EventoClubeController::class, 'eventInvites']);

        // Clube envia convite de evento pelo chat
        Route::post('/chat/send-event-invite', [ChatController::class, 'sendEventInvite']);

        // Clube cancela convite de um usuário para um evento
        Route::post('/convites/{conviteId}/cancelar', [ChatController::class, 'clubeCancelInvite']);

        // Rotas para o clube gerenciar sua conta
        Route::delete('/delete', [AuthClubeController::class, 'deleteAccount']);

        Route::put('/{id}', [ClubeController::class, 'update'])->whereNumber('id');
        Route::get('/{id}', [ClubeController::class, 'show'])->whereNumber('id');
        Route::delete('/{id}', [ClubeController::class, 'destroy'])->whereNumber('id');

        Route::put('/email',   [ClubeController::class, 'updateEmail']);
        Route::put('/cnpj',    [ClubeController::class, 'updateCnpj']);
        Route::put('/senha',   [ClubeController::class, 'updatePassword']);
        Route::delete('/conta', [ClubeController::class, 'destroyMe']);
        // Fim Listas do Clube
    });

    /*  Route::middleware('auth:sanctum')->group(function () {
            // Seguir e deixar de seguir clube protegidos
            Route::post('/{id}/seguir', [SeguidorController::class, 'seguirClube']);
            Route::post('/{id}/deixar-de-seguir', [SeguidorController::class, 'deixarDeSeguirClube']);
        }); 
    */
});

// --- ROTAS DE CHAT ---
Route::middleware('auth:sanctum,club_sanctum,adm_sanctum')->group(function () {
    Broadcast::routes(['middleware' => ['auth:sanctum,club_sanctum,adm_sanctum']]);

    Route::post('/chat/invite', [ChatController::class, 'sendEventInvite']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::post('/accept_invite/{conviteId}', [ChatController::class, 'aceitoInvite']);
    Route::get('/conversations', [ConversationController::class, 'index']);
    Route::get('/conversations/{id}/messages', [ConversationController::class, 'getMessages']);
});


Route::get('/teste-chat', function () {
    $remetente = Clube::find(1); // Altere o ID conforme necessário
    if (!$remetente) {
        return "Erro: Clube remetente com ID 1 não encontrado.";
    }

    Sanctum::actingAs(
        $remetente,
        ['*'],
        'club_sanctum' // Chat isso aqui em --Bruno 
    );

    $requestFalso = new \Illuminate\Http\Request();
    $requestFalso->replace([
        'receiver_id'   => 1,
        'receiver_type' => 'usuario', // usuario ou clube
        'message'       => 'Mensagem de teste de um Clube para um Usuário!'
    ]);

    $chatController = new ChatController();
    return $chatController->sendMessage($requestFalso);
});

Route::get('/teste-chat-usuario', function () {
    $remetente = Usuario::find(2);
    if (!$remetente) {
        return "Erro: Usuário remetente com ID 2 não encontrado.";
    }

    Sanctum::actingAs(
        $remetente,
        ['*'],
        'sanctum'
    );

    $requestFalso = new \Illuminate\Http\Request();
    $requestFalso->replace([
        'receiver_id'   => 1,
        'receiver_type' => 'usuario',  // usuario ou clube
        'message'       => 'Mensagem de teste de um Usuário para um Clube!'
    ]);

    $chatController = new ChatController();
    return $chatController->sendMessage($requestFalso);
});

//Admin
Route::prefix('admin')->group(function () {
    Route::post('/login', [AdmController::class, 'loginAdm']);

    Route::middleware(['web', 'auth:adm_sanctum'])->group(function () {
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

        Route::put(
            '/oportunidade/{oportunidade}/status',
            [AdminSistemaController::class, 'oportunidadeUpdateStatus']
        );

        Route::get('/oportunidade/{id}', [OportunidadeController::class, 'show']);

        Route::post('/usuario/{id}/ativar', [AdminSistemaController::class, 'ativarUsuario']);
        Route::post('/usuario/{id}/bloquear', [AdminSistemaController::class, 'bloquearUsuario']);

        Route::post('/usuario/{id}/update', [AdminSistemaController::class, 'usuarioUpdateStatus']);

        Route::post('/clube/{id}/ativar', [AdminSistemaController::class, 'ativarClube']);
        Route::post('/clube/{id}/rejeitar', [AdminSistemaController::class, 'rejeitarClube']);
        Route::post('/clube/{id}/bloquear', [AdminSistemaController::class, 'bloquearClube']);

        Route::post('/clube/{id}/update', [AdminSistemaController::class, 'clubeUpdateStatus']);

        Route::put('/perfil/identidade', [AdminProfileController::class, 'updateIdentidade']);
        Route::put('/perfil/informacoes', [AdminProfileController::class, 'updateInformacoes']);


        Route::get('/oportunidades', [OportunidadeController::class, 'index']);
        Route::get('/list', [AdminSistemaController::class, 'ListOportunidades']);
        Route::get('/oportunidades/pendentes', [AdminSistemaController::class, 'listPending']);
        Route::post('/oportunidades/{id}/aprovar', [AdminSistemaController::class, 'aproved']);
        Route::post('/oportunidades/{id}/recusar', [AdminSistemaController::class, 'reject']);

        Route::delete('/listas/{id}', [ListaClubeController::class, 'destroy']);
        Route::get('/listas/{id}', [ListaClubeController::class, 'show']);

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
        Route::post('/posicao', [AdminSistemaController::class, 'Posicaostore']);
        Route::put('/posicao/{id}', [AdminSistemaController::class, 'Posicaoupdate']);
        Route::delete('/posicao/{id}', [AdminSistemaController::class, 'Posicaodestroy']);

        Route::get('/usuario/list', [AdminSistemaController::class, 'listarUsuarios']);
        Route::get('/clube/list', [AdminSistemaController::class, 'listarClubes']);
        Route::post('/esporte/{id}/ativar', [AdminSistemaController::class, 'esporteAtivar']);
        Route::post('/esporte/{id}/deletar', [AdminSistemaController::class, 'esporteDeletar']);
        Route::post('/lista/{id}/ativar', [AdminSistemaController::class, 'listaAtivar']);
        Route::post('/lista/{id}/deletar', [AdminSistemaController::class, 'listaDeletar']);
        Route::post('/funcoes/{id}/ativar', [AdminSistemaController::class, 'ativarFuncoes']);
        Route::post('/funcoes/{id}/deletar', [AdminSistemaController::class, 'deletarFuncoes']);

        Route::get('/posicao/{id}', [AdminSistemaController::class, 'showPosicao']);

        Route::get('/posicao', [AdminSistemaController::class, 'listarPosicoes']);
        Route::post('/posicao', [AdminSistemaController::class, 'storePosicao']);      // Antes era Posicaostore
        Route::put('/posicao/{id}', [AdminSistemaController::class, 'updatePosicao']);    // Antes era Posicaoupdate
        Route::delete('/posicao/{id}', [AdminSistemaController::class, 'destroyPosicao']); // Antes era Posicaodestroy

        Route::get('/funcao', [AdminSistemaController::class, 'listarFuncoes'])->name('admin.funcoes.listar');
        Route::post('/funcao', [FuncaoController::class, 'store']);
        Route::put('/funcao/{id}', [FuncaoController::class, 'update']);
        Route::delete('/funcao/{id}', [FuncaoController::class, 'destroy']);
        Route::get('/funcao/{id}', [FuncaoController::class, 'show']);

        Route::get('/esporte', [AdminSistemaController::class, 'ListarEsportes']);
        Route::get('/esporte/{id}', [AdminSistemaController::class, 'showEsporte']);
        Route::get('/esporte/{id}/posicoes/', [AdminSistemaController::class, 'showPosicoesByEsporte']);

        Route::get('/caracteristica/{id}', [AdminSistemaController::class, 'listarCaracteristicasId']);
        Route::post('/caracteristica', [AdminSistemaController::class, 'storeCaracteristica']);
        Route::put('/caracteristica/{id}', [AdminSistemaController::class, 'updateCaracteristica']);
        Route::delete('/caracteristica/{id}', [AdminSistemaController::class, 'destroyCaracteristica']);

        // Dashboard Admin - últimos cadastros de usuários
        Route::get('/dashboard/ultimos-cadastros', [DashAdminController::class, 'ultimosCadastros']);

        // Dashboard Admin - 5 oportunidades com mais inscrições
        Route::get('/dashboard/oportunidades-inscricoes', [DashAdminController::class, 'oportunidadesInscricoes']);

        // Dashboard Admin - 5 clubes mais ativos
        Route::get('/dashboard/clubes-mais-ativos', [DashAdminController::class, 'clubesMaisAtivos']);

        // Dashboard Admin - atividades recentes (oportunidades + inscrições)
        Route::get('/dashboard/atividades-recentes', [DashAdminController::class, 'atividadesRecentes']);

        // Dashboard Admin - cards gerais (atletas mês, clubes ativos, oportunidades ativas, inscrições totais)
        Route::get('/dashboard/resumo-geral', [DashAdminController::class, 'resumoGeral']);

        // Dashboard Admin - crescimento de usuários mensal
        Route::get('/dashboard/crescimento-usuarios-mensal', [DashAdminController::class, 'crescimentoUsuariosMensal']);

        // Dashboard Admin - inscrições mensais
        Route::get('/dashboard/inscricoes-mensais', [DashAdminController::class, 'inscricoesMensais']);

        // Dashboard Admin - distribuição de oportunidades entre esportes
        Route::get('/dashboard/distribuicao-oportunidades-esporte', [DashAdminController::class, 'distribuicaoOportunidadesPorEsporte']);

        //SEJA FELIZ JOAO --LUAN
        Route::get('/eventos', [AdminEventoController::class, 'listAllEvents']);
        Route::get('/eventos/{eventoId}', [AdminEventoController::class, 'showEvent']);
        Route::put('/eventos/{eventoId}', [AdminEventoController::class, 'updateEvent']);
        Route::delete('/eventos/{eventoId}', [AdminEventoController::class, 'deleteEvent']);

        // Convites / "inscritos" de um evento (Admin)
        Route::get('/eventos/{eventoId}/convites', [AdminEventoController::class, 'eventInvitesAdmin']);

         // ROTA DO CSV
        Route::get('/export/csv', [AdminSistemaController::class, 'exportDadosSistema'])->name('admin.export.csv');
        
          Route::post('/oportunidades/{id}/approve', [DashAdminController::class, 'approveOpportunity'])->name('admin.oportunidades.approve');

            Route::post('/oportunidades/{id}/reject', [DashAdminController::class, 'rejectOpportunity'])->name('admin.oportunidades.reject');

        Route::prefix('oportunidades')->group(function () {

            // GET /api/admin/oportunidades/metrics
            Route::get('/metrics', [AdminOportunidadesController::class, 'metrics']);

            // GET /api/admin/oportunidades/list
            Route::get('/list', [AdminOportunidadesController::class, 'list']);

            // GET /api/admin/oportunidades/{oportunidade}
            Route::get('/{oportunidade}', [AdminOportunidadesController::class, 'show']);

            // PATCH /api/admin/oportunidades/{oportunidade}
            Route::put('/{oportunidade}', [AdminOportunidadesController::class, 'update']);

            // PATCH /api/admin/oportunidades/{oportunidade}/status
            Route::put('/{oportunidade}/status', [AdminOportunidadesController::class, 'updateStatus']);

            // GET /api/admin/oportunidades/{oportunidade}/inscricoes
            Route::get('/{oportunidade}/inscricoes', [AdminOportunidadesController::class, 'listInscricoes']);

            // DELETE /api/admin/oportunidades/{oportunidade}
            Route::delete('/{oportunidade}', [AdminOportunidadesController::class, 'destroy']);

        });
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