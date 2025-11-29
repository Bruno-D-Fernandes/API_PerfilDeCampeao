<?php

namespace App\Http\Controllers;

use App\Events\OpportunityStatusChangeEvent;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Oportunidade;
use App\Models\Usuario;
use App\Models\Clube;
use App\Models\Categoria;
use App\Models\Lista;
use App\Models\Caracteristica;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Esporte;
use App\Models\Funcao;
use App\Models\Posicao; 
use Illuminate\Validation\Rule;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Inscricao;
use App\Models\Evento;
use App\Models\ConviteEvento;


class AdminSistemaController extends Controller
{


protected function buildCsv(array $header, iterable $rows): string
{
    $fh = fopen('php://temp', 'r+');
    fputcsv($fh, $header, ';');
    foreach ($rows as $row) {
        fputcsv($fh, $row, ';');
    }
    rewind($fh);
    return stream_get_contents($fh);
}

//Maldito seja o demonio que criou csv, apenas --Luan

public function exportDadosSistema(Request $request)
{
    $admin = $request->user();
    if (!$admin instanceof Admin) {
        return response()->json(['message' => 'Somente admin autenticado'], 403);
    }

    $zip = new ZipArchive();
    $fileName = 'dados_sistema_' . now()->format('Ymd_His') . '.zip';
    $zipPath = storage_path('app/' . $fileName);

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        return response()->json(['message' => 'Não foi possível gerar o arquivo'], 500);
    }

    $usuarios = Usuario::withCount(['perfis', 'inscricoes', 'listas'])->get();
    $usuariosHeader = [
        'id',
        'nome',
        'email',
        'data_nascimento',
        'genero',
        'estado',
        'cidade',
        'altura_cm',
        'peso_kg',
        'pe_dominante',
        'mao_dominante',
        'status',
        'reviewed_by',
        'reviewed_at',
        'bloque_reason',
        'perfis_count',
        'inscricoes_count',
        'listas_count',
        'created_at',
        'updated_at',
    ];
    $usuariosRows = $usuarios->map(function (Usuario $u) {
        return [
            $u->id,
            $u->nomeCompletoUsuario,
            $u->emailUsuario,
            $u->dataNascimentoUsuario?->format('Y-m-d'),
            $u->generoUsuario,
            $u->estadoUsuario,
            $u->cidadeUsuario,
            $u->alturaCm,
            $u->pesoKg,
            $u->peDominante,
            $u->maoDominante,
            $u->status,
            $u->reviewed_by,
            $u->reviewed_at?->toDateTimeString(),
            $u->bloque_reason,
            $u->perfis_count,
            $u->inscricoes_count,
            $u->listas_count,
            $u->created_at?->toDateTimeString(),
            $u->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('usuarios.csv', $this->buildCsv($usuariosHeader, $usuariosRows));

    $clubes = Clube::with(['categoria:id,nomeCategoria', 'esporte:id,nomeEsporte'])
        ->withCount(['oportunidades', 'listas', 'membros'])
        ->get();
    $clubesHeader = [
        'id',
        'nome',
        'cnpj',
        'email',
        'cidade',
        'estado',
        'ano_criacao',
        'endereco',
        'bio',
        'categoria_id',
        'categoria_nome',
        'esporte_id',
        'esporte_nome',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'bloque_reason',
        'oportunidades_count',
        'listas_count',
        'membros_count',
        'created_at',
        'updated_at',
    ];
    $clubesRows = $clubes->map(function (Clube $c) {
        return [
            $c->id,
            $c->nomeClube,
            $c->cnpjClube,
            $c->emailClube,
            $c->cidadeClube,
            $c->estadoClube,
            $c->anoCriacaoClube?->format('Y-m-d'),
            $c->enderecoClube,
            $c->bioClube,
            $c->categoria_id,
            $c->categoria?->nomeCategoria,
            $c->esporte_id,
            $c->esporte?->nomeEsporte,
            $c->status,
            $c->reviewed_by,
            $c->reviewed_at?->toDateTimeString(),
            $c->rejection_reason,
            $c->bloque_reason,
            $c->oportunidades_count,
            $c->listas_count,
            $c->membros_count,
            $c->created_at?->toDateTimeString(),
            $c->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('clubes.csv', $this->buildCsv($clubesHeader, $clubesRows));

    $esportes = Esporte::withCount(['posicoes', 'caracteristicas', 'clubes'])->get();
    $esportesHeader = [
        'id',
        'nome',
        'descricao',
        'status',
        'posicoes_count',
        'caracteristicas_count',
        'clubes_count',
        'created_at',
        'updated_at',
    ];
    $esportesRows = $esportes->map(function (Esporte $e) {
        return [
            $e->id,
            $e->nomeEsporte,
            $e->descricaoEsporte,
            $e->status,
            $e->posicoes_count,
            $e->caracteristicas_count,
            $e->clubes_count,
            $e->created_at?->toDateTimeString(),
            $e->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('esportes.csv', $this->buildCsv($esportesHeader, $esportesRows));

    $posicoes = Posicao::with('esporte:id,nomeEsporte')->withCount(['usuarios', 'oportunidades'])->get();
    $posicoesHeader = [
        'id',
        'nome',
        'esporte_id',
        'esporte_nome',
        'usuarios_count',
        'oportunidades_count',
        'created_at',
        'updated_at',
    ];
    $posicoesRows = $posicoes->map(function (Posicao $p) {
        return [
            $p->id,
            $p->nomePosicao,
            $p->idEsporte,
            $p->esporte?->nomeEsporte,
            $p->usuarios_count,
            $p->oportunidades_count,
            $p->created_at?->toDateTimeString(),
            $p->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('posicoes.csv', $this->buildCsv($posicoesHeader, $posicoesRows));

    $caracteristicas = Caracteristica::with('esporte:id,nomeEsporte')->get();
    $caracteristicasHeader = [
        'id',
        'caracteristica',
        'unidade_medida',
        'esporte_id',
        'esporte_nome',
        'created_at',
        'updated_at',
    ];
    $caracteristicasRows = $caracteristicas->map(function (Caracteristica $c) {
        return [
            $c->id,
            $c->caracteristica,
            $c->unidade_medida,
            $c->esporte_id,
            $c->esporte?->nomeEsporte,
            $c->created_at?->toDateTimeString(),
            $c->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('caracteristicas.csv', $this->buildCsv($caracteristicasHeader, $caracteristicasRows));

    $categorias = Categoria::withCount('clubes')->get();
    $categoriasHeader = [
        'id',
        'nome',
        'descricao',
        'clubes_count',
        'created_at',
        'updated_at',
    ];
    $categoriasRows = $categorias->map(function (Categoria $c) {
        return [
            $c->id,
            $c->nomeCategoria,
            $c->descricaoCategoria,
            $c->clubes_count,
            $c->created_at?->toDateTimeString(),
            $c->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('categorias.csv', $this->buildCsv($categoriasHeader, $categoriasRows));

    $funcoes = Funcao::all();
    $funcoesHeader = [
        'id',
        'nome',
        'descricao',
        'status',
        'created_at',
        'updated_at',
    ];
    $funcoesRows = $funcoes->map(function (Funcao $f) {
        return [
            $f->id,
            $f->nome,
            $f->descricao,
            $f->status,
            $f->created_at?->toDateTimeString(),
            $f->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('funcoes.csv', $this->buildCsv($funcoesHeader, $funcoesRows));

    $listas = Lista::with(['clube:id,nomeClube'])->withCount('usuarios')->get();
    $listasHeader = [
        'id',
        'nome',
        'descricao',
        'clube_id',
        'clube_nome',
        'status',
        'usuarios_count',
        'created_at',
        'updated_at',
    ];
    $listasRows = $listas->map(function (Lista $l) {
        return [
            $l->id,
            $l->nome,
            $l->descricao,
            $l->clube_id,
            $l->clube?->nomeClube,
            $l->status,
            $l->usuarios_count,
            $l->created_at?->toDateTimeString(),
            $l->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('listas.csv', $this->buildCsv($listasHeader, $listasRows));

    $listaUsuario = DB::table('lista_usuario')->get();
    $mapListas = Lista::pluck('nome', 'id')->all();
    $mapUsuarios = Usuario::pluck('nomeCompletoUsuario', 'id')->all();
    $listasUsuariosHeader = [
        'lista_id',
        'lista_nome',
        'usuario_id',
        'usuario_nome',
        'created_at',
        'updated_at',
    ];
    $listasUsuariosRows = $listaUsuario->map(function ($row) use ($mapListas, $mapUsuarios) {
        return [
            $row->lista_id,
            $mapListas[$row->lista_id] ?? null,
            $row->usuario_id,
            $mapUsuarios[$row->usuario_id] ?? null,
            isset($row->created_at) ? (string) $row->created_at : null,
            isset($row->updated_at) ? (string) $row->updated_at : null,
        ];
    });
    $zip->addFromString('listas_usuarios.csv', $this->buildCsv($listasUsuariosHeader, $listasUsuariosRows));

    $oportunidades = Oportunidade::with(['clube:id,nomeClube', 'esporte:id,nomeEsporte', 'posicoes:id,nomePosicao'])
        ->withCount(['inscricoes', 'inscricoesAprovadas', 'inscricoesRejeitadas', 'inscricoesPendentes'])
        ->get();
    $oportunidadesHeader = [
        'id',
        'titulo',
        'descricao',
        'data_postagem',
        'esporte_id',
        'esporte_nome',
        'clube_id',
        'clube_nome',
        'idade_minima',
        'idade_maxima',
        'limite_inscricoes',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'total_inscricoes',
        'inscricoes_aprovadas',
        'inscricoes_rejeitadas',
        'inscricoes_pendentes',
        'posicoes_ids',
        'posicoes_nomes',
        'created_at',
        'updated_at',
    ];
    $oportunidadesRows = $oportunidades->map(function (Oportunidade $o) {
        $posicoesIds = $o->posicoes->pluck('id')->implode('|');
        $posicoesNomes = $o->posicoes->pluck('nomePosicao')->implode('|');
        return [
            $o->id,
            $o->tituloOportunidades,
            $o->descricaoOportunidades,
            $o->datapostagemOportunidades?->format('Y-m-d'),
            $o->esporte_id,
            $o->esporte?->nomeEsporte,
            $o->clube_id,
            $o->clube?->nomeClube,
            $o->idadeMinima,
            $o->idadeMaxima,
            $o->limite_inscricoes,
            $o->status,
            $o->reviewed_by,
            $o->reviewed_at?->toDateTimeString(),
            $o->rejection_reason,
            $o->inscricoes_count,
            $o->inscricoes_aprovadas_count,
            $o->inscricoes_rejeitadas_count,
            $o->inscricoes_pendentes_count,
            $posicoesIds,
            $posicoesNomes,
            $o->created_at?->toDateTimeString(),
            $o->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('oportunidades.csv', $this->buildCsv($oportunidadesHeader, $oportunidadesRows));

    $pivotOppPos = DB::table('oportunidades_posicoes')->get();
    $mapOpp = Oportunidade::pluck('tituloOportunidades', 'id')->all();
    $mapPos = Posicao::pluck('nomePosicao', 'id')->all();
    $oppPosHeader = [
        'oportunidade_id',
        'oportunidade_titulo',
        'posicao_id',
        'posicao_nome',
        'created_at',
        'updated_at',
    ];
    $oppPosRows = $pivotOppPos->map(function ($row) use ($mapOpp, $mapPos) {
        return [
            $row->oportunidades_id,
            $mapOpp[$row->oportunidades_id] ?? null,
            $row->posicoes_id,
            $mapPos[$row->posicoes_id] ?? null,
            isset($row->created_at) ? (string) $row->created_at : null,
            isset($row->updated_at) ? (string) $row->updated_at : null,
        ];
    });
    $zip->addFromString('oportunidades_posicoes.csv', $this->buildCsv($oppPosHeader, $oppPosRows));

    $inscricoes = Inscricao::with(['oportunidade:id,tituloOportunidades,clube_id', 'oportunidade.clube:id,nomeClube', 'usuario:id,nomeCompletoUsuario,emailUsuario'])->get();
    $inscricoesHeader = [
        'id',
        'oportunidade_id',
        'oportunidade_titulo',
        'clube_id',
        'clube_nome',
        'usuario_id',
        'usuario_nome',
        'usuario_email',
        'status',
        'mensagem',
        'created_at',
        'updated_at',
    ];
    $inscricoesRows = $inscricoes->map(function (Inscricao $i) {
        return [
            $i->id,
            $i->oportunidade_id,
            $i->oportunidade?->tituloOportunidades,
            $i->oportunidade?->clube_id,
            $i->oportunidade?->clube?->nomeClube,
            $i->usuario_id,
            $i->usuario?->nomeCompletoUsuario,
            $i->usuario?->emailUsuario,
            $i->status,
            $i->mensagem,
            $i->created_at?->toDateTimeString(),
            $i->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('inscricoes.csv', $this->buildCsv($inscricoesHeader, $inscricoesRows));

    $eventos = Evento::with(['clube:id,nomeClube'])->withCount('convites')->get();
    $eventosHeader = [
        'id',
        'clube_id',
        'clube_nome',
        'titulo',
        'descricao',
        'data_hora_inicio',
        'data_hora_fim',
        'cep',
        'estado',
        'cidade',
        'bairro',
        'rua',
        'numero',
        'complemento',
        'limite_participantes',
        'color',
        'convites_count',
        'created_at',
        'updated_at',
    ];
    $eventosRows = $eventos->map(function (Evento $e) {
        return [
            $e->id,
            $e->clube_id,
            $e->clube?->nomeClube,
            $e->titulo,
            $e->descricao,
            $e->data_hora_inicio?->toDateTimeString(),
            $e->data_hora_fim?->toDateTimeString(),
            $e->cep,
            $e->estado,
            $e->cidade,
            $e->bairro,
            $e->rua,
            $e->numero,
            $e->complemento,
            $e->limite_participantes,
            $e->color,
            $e->convites_count,
            $e->created_at?->toDateTimeString(),
            $e->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('eventos.csv', $this->buildCsv($eventosHeader, $eventosRows));

    $convites = ConviteEvento::with(['evento:id,titulo', 'usuario:id,nomeCompletoUsuario'])->get();
    $convitesHeader = [
        'id',
        'evento_id',
        'evento_titulo',
        'usuario_id',
        'usuario_nome',
        'status',
        'sent_at',
        'responded_at',
        'expires_at',
        'color',
        'created_at',
        'updated_at',
    ];
    $convitesRows = $convites->map(function (ConviteEvento $c) {
        return [
            $c->id,
            $c->evento_id,
            $c->evento?->titulo,
            $c->usuario_id,
            $c->usuario?->nomeCompletoUsuario,
            $c->status,
            $c->sent_at?->toDateTimeString(),
            $c->responded_at?->toDateTimeString(),
            $c->expires_at?->toDateTimeString(),
            $c->color,
            $c->created_at?->toDateTimeString(),
            $c->updated_at?->toDateTimeString(),
        ];
    });
    $zip->addFromString('convites_evento.csv', $this->buildCsv($convitesHeader, $convitesRows));

    $metrics = [
        ['total_usuarios', Usuario::count()],
        ['total_usuarios_ativos', Usuario::ativos()->count()],
        ['total_usuarios_bloqueados', Usuario::bloqueados()->count()],
        ['total_usuarios_deletados', Usuario::deletados()->count()],
        ['total_clubes', Clube::count()],
        ['total_clubes_ativos', Clube::ativos()->count()],
        ['total_clubes_pendentes', Clube::pendentes()->count()],
        ['total_clubes_rejeitados', Clube::rejeitados()->count()],
        ['total_clubes_bloqueados', Clube::bloqueados()->count()],
        ['total_oportunidades', Oportunidade::count()],
        ['total_oportunidades_pending', Oportunidade::pending()->count()],
        ['total_oportunidades_approved', Oportunidade::approved()->count()],
        ['total_oportunidades_rejected', Oportunidade::rejected()->count()],
        ['total_inscricoes', Inscricao::count()],
        ['total_eventos', Evento::count()],
        ['total_convites_evento', ConviteEvento::count()],
        ['total_esportes', Esporte::count()],
        ['total_posicoes', Posicao::count()],
        ['total_listas', Lista::count()],
        ['total_funcoes', Funcao::count()],
        ['total_categorias', Categoria::count()],
    ];
    $metricsHeader = ['metrica', 'valor'];
    $zip->addFromString('resumo_metricas.csv', $this->buildCsv($metricsHeader, $metrics));

    $zip->close();

    return response()->download($zipPath, $fileName)->deleteFileAfterSend(true);
}



public function oportunidadeUpdateStatus(Request $request, Oportunidade $oportunidade)
{
    $data = $request->validate([
        'status' => [
            'required',
            Rule::in([
                Oportunidade::STATUS_REJECTED,
                Oportunidade::STATUS_APPROVED
            ]),
        ],
        'rejection_reason' => [
            'nullable',
            Rule::requiredIf($request->status == Oportunidade::STATUS_REJECTED),
            'string',
            'max:255'
        ]
    ]);

    $admin = $request->user();

    $oportunidade->status = $data['status'];
    $oportunidade->reviewed_by = $admin->id;
    $oportunidade->reviewed_at = now();

    if ($data['status'] == Oportunidade::STATUS_REJECTED) {
        $oportunidade->rejection_reason = $data['rejection_reason'];
    } else {
        $oportunidade->rejection_reason = null;
    }

    $oportunidade->save();

    return response()->json(
        $oportunidade->load('clube', 'esporte', 'posicao', 'inscricoes')
    );
}

public function usuarioUpdateStatus(Request $request, Usuario $usuario)
{
    $admin = $request->user();
    if (!$admin || !($admin instanceof Admin)) {
        return response()->json(['message' => 'Somente admin autenticado'], 403);
    }

    $data = $request->validate([
        'status' => [
            'required',
            Rule::in([
                Usuario::STATUS_ATIVO,
                Usuario::STATUS_BLOQUEADO,
            ]),
        ],
        'bloque_reason' => [
            'nullable',
            Rule::requiredIf(fn () => $request->status == Usuario::STATUS_BLOQUEADO),
            'string',
            'max:255',
        ],
    ]);

    $usuario->status       = $data['status'];
    $usuario->reviewed_by  = $admin->id;
    $usuario->reviewed_at  = now();

    if ($data['status'] == Usuario::STATUS_BLOQUEADO) {
        $usuario->bloque_reason = $data['bloque_reason'];
    } else {
        $usuario->bloque_reason = null;
    }

   $usuario->save();

    return response()->json(
        $usuario->fresh()
    );
}

public function bloquearUsuario(Request $request, $id){
    $admin = $request->user();
    if (!$admin || !($admin instanceof Admin)) {
        return response()->json(['message' => 'Somente admin autenticado'], 403);
    }
    $usuario = Usuario::find($id);

    if (!$usuario){
         return response()->json(['message' => 'Usuário não encontrado'], 404);
    }

    
    $validatedData = $request->validate([
        'bloque_reason' => 'required|string|max:1000',
    ]);

    $usuario->update([
        'status'         => Usuario::STATUS_BLOQUEADO,
        'reviewed_by'    => $admin->id,
        'reviewed_at'    => now(),
        'bloque_reason' => $validatedData['bloque_reason'],
    ]);
    return response()->json(['message' => 'Usuário bloqueado com sucesso'], 200);
}

public function ativarUsuario(Request $request, $id){
    $admin = $request->user();
    if (!$admin || !($admin instanceof Admin)) {
        return response()->json(['message' => 'Somente admin autenticado'], 403);
    }
    $usuario = Usuario::find($id);
    if (!$usuario){
         return response()->json(['message' => 'Usuário não encontrado'], 404);
    }

    $usuario->update([
        'status'         => Usuario::STATUS_ATIVO,
        'reviewed_by'    => $admin->id,
        'reviewed_at'    => now(),
        'bloque_reason' => null,
    ]);

    return response()->json(['message' => 'Usuário ativado com sucesso'], 200);
}

public function clubeUpdateStatus(Request $request, Clube $clube)
{
    $admin = $request->user();
    if (!$admin || !($admin instanceof Admin)) {
        return response()->json(['message' => 'Somente admin autenticado'], 403);
    }

    $data = $request->validate([
        'status' => [
            'required',
            Rule::in([
                Clube::STATUS_ATIVO,
                Clube::STATUS_REJEITADO,
                Clube::STATUS_BLOQUEADO,
            ]),
        ],
        'rejection_reason' => [
            'nullable',
            Rule::requiredIf(fn () => $request->status == Clube::STATUS_REJEITADO),
            'string',
            'max:255',
        ],
    ]);

    $clube->status       = $data['status'];
    $clube->reviewed_by  = $admin->id;
    $clube->reviewed_at  = now();

    if ($data['status'] == Clube::STATUS_REJEITADO) {
        $clube->rejection_reason = $data['rejection_reason'];
    } else {
        $clube->rejection_reason = null;
    }

   $clube->save();

    return response()->json(
        $clube->fresh()->load('categoria', 'esporte')
    );
}

public function ativarClube(Request $request, $id){
    $admin = $request->user();
    if (!$admin || !($admin instanceof Admin)) {
        return response()->json(['message' => 'Somente admin autenticado'], 403);
    }
    $clube = Clube::find($id);
    if (!$clube) return response()->json(['message' => 'Clube não encontrado'], 404);

    $clube->update([
        'status'         => Clube::STATUS_ATIVO,
        'reviewed_by'    => $admin->id,
        'reviewed_at'    => now(),
        'rejection_reason' => null,
        'bloque_reason' => null,
    ]);

    return response()->json(['message' => 'Clube ativado com sucesso'], 200);
}

public function rejeitarClube(Request $request, $id){
    $admin = $request->user();
    if (!$admin || !($admin instanceof Admin)) {
        return response()->json(['message' => 'Somente admin autenticado'], 403);
    }
    $clube = Clube::find($id);
    if (!$clube) return response()->json(['message' => 'Clube não encontrado'], 404);

    $validatedData = $request->validate([
        'rejection_reason' => 'required|string|max:1000',
    ]);

    $clube->update([
        'status'         => Clube::STATUS_REJEITADO,
        'reviewed_by'    => $admin->id,
        'reviewed_at'    => now(),
        'rejection_reason' => $validatedData['rejection_reason'],
        'bloque_reason' => null,
    ]);

    return response()->json(['message' => 'Clube rejeitado com sucesso'], 200);
}

public function bloquearClube(Request $request, $id){
    $admin = $request->user();
    if (!$admin || !($admin instanceof Admin)) {
        return response()->json(['message' => 'Somente admin autenticado'], 403);
    }
    $clube = Clube::find($id);
    if (!$clube) return response()->json(['message' => 'Clube não encontrado'], 404);

    
    $validatedData = $request->validate([
        'bloque_reason' => 'required|string|max:1000',
    ]);

    $clube->update([
        'status'         => Clube::STATUS_BLOQUEADO,
        'reviewed_by'    => $admin->id,
        'reviewed_at'    => now(),
        'rejection_reason' => null,
        'bloque_reason' => $validatedData['bloque_reason'],
    ]);
    return response()->json(['message' => 'Clube bloqueado com sucesso'], 200);
}

public function listarUsuarios(Request $request)
{
    $status  = $request->query('status');
    $search  = $request->query('search');
    $perPage = (int) $request->query('per_page', 15);

    $q = Usuario::query();

    if ($status) {
        $q->where('status', $status);
    }

    if ($search) {
        $q->where(function ($w) use ($search) {
            $w->where('nomeCompletoUsuario', 'like', "%{$search}%")
              ->orWhere('emailUsuario', 'like', "%{$search}%")
              ->orWhere('cidadeUsuario', 'like', "%{$search}%")
              ->orWhere('estadoUsuario', 'like', "%{$search}%");
        });
    }

    $usuarios = $q
        ->orderByDesc('created_at')
        ->paginate($perPage);

    return response()->json($usuarios, 200);
}

public function listarClubes(Request $request)
{
    $status  = $request->query('status');
    $search  = $request->query('search');
    $perPage = (int) $request->query('per_page', 15);

    $q = Clube::query();

    if ($status) {
        $q->where('status', $status);
    }

    if ($search) {
        $q->where(function ($w) use ($search) {
            $w->where('nomeClube', 'like', "%{$search}%")
              ->orWhere('emailClube', 'like', "%{$search}%")
              ->orWhere('cidadeClube', 'like', "%{$search}%")
              ->orWhere('estadoClube', 'like', "%{$search}%");
        });
    }

    $clubes = $q
        ->orderByDesc('created_at')
        ->paginate($perPage);

    return response()->json($clubes, 200);
}


    public function showEsporte(Request $request, $id)
    {
        $esporte = Esporte::with('posicoes', 'caracteristicas')->findOrFail($id);

        return response()->json($esporte, 200);
    }

    public function ListarEsportes(Request $request)
    {
        try {
            $search  = $request->query('search');
            $perPage = (int) $request->query('per_page', 15);

            $q = Esporte::query();

            if ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('nomeEsporte', 'like', "%{$search}%")
                    ->orWhere('descricaoEsporte', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
                });
            }

            $esportes = $q
                ->orderBy('nomeEsporte')
                ->paginate($perPage);

            return response()->json($esportes, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Erro ao listar esportes',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function showPosicoesByEsporte(Request $request, $id)
    {
        $esporte = Esporte::findOrFail($id);

        return response()->json($esporte->posicoes(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Esportestore(Request $request)
    {
        $ValidatedData = $request->validate([
            'nomeEsporte' => 'required|string|max:255',
            'descricaoEsporte' => 'nullable|string',
        ]);

        $esporte = Esporte::create([
            'nomeEsporte' => $ValidatedData['nomeEsporte'],
            'descricaoEsporte' => $ValidatedData['descricaoEsporte'] ?? null,
        ]);

        return response()->json($esporte, 201);
    }

    public function CategoriaStore(Request $request)
    {
        $ValidatedData = $request->validate([
            'nomeCategoria' => 'required|string|max:255',
            'descricaoCategoria' => 'nullable|string',
        ]);

        $categoria = Categoria::create([
            'nomeCategoria' => $ValidatedData['nomeCategoria'],
            'descricaoCategoria' => $ValidatedData['descricaoCategoria'] ?? null,
        ]);

        return response()->json($categoria, 201);
    }

    public function listarCategorias(Request $request)
    {
        try {
            $search  = $request->query('search');
            $perPage = (int) $request->query('per_page', 15);

            $q = Categoria::query();

            if ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('nomeCategoria', 'like', "%{$search}%")
                    ->orWhere('descricaoCategoria', 'like', "%{$search}%");
                });
            }

            $categorias = $q
                ->orderBy('nomeCategoria')
                ->paginate($perPage);

            return response()->json($categorias, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Erro ao listar categorias',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function CategoriaUpdate(string $id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }
        $ValidatedData = request()->validate([
            'nomeCategoria' => 'sometimes|required|string|max:255',
            'descricaoCategoria' => 'sometimes|nullable|string',
        ]);
        $categoria->update($ValidatedData);
        return response()->json($categoria, 200);
    }

    public function CategoriaDestroy(string $id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }
        $categoria->delete();
        return response()->json(['message' => 'Categoria deletada com sucesso'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function EsporteUpdate(string $id)
    {
        $esporte = Esporte::find($id);

        if (!$esporte) {
            return response()->json(['message' => 'Esporte não encontrado'], 404);
        }

        $ValidatedData = request()->validate([
            'nomeEsporte' => 'sometimes|required|string|max:255',
            'descricaoEsporte' => 'sometimes|nullable|string',
        ]);

        $esporte->update($ValidatedData);

        return response()->json($esporte->fresh()->load('caracteristicas', 'posicoes'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function EsporteDestroy(string $id)
    {
        $esporte = Esporte::find($id);

        if (!$esporte) {
            return response()->json(['message' => 'Esporte não encontrado'], 404);
        }
        
        $esporte->delete();
        return response()->json(['message' => 'Esporte deletado com sucesso'], 200);
    }

    public function showPosicao($id)
{
    try {
        $posicao = \App\Models\Posicao::findOrFail($id);
        return response()->json($posicao, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Posição não encontrada.'], 404);
    }
}

    public function listarPosicoes(Request $request)
{
    $idEsporte = $request->query('idEsporte');
    $search    = $request->query('search');
    $perPage   = (int) $request->query('per_page', 15);

    $q = Posicao::with('esporte:id,nomeEsporte')
        ->when($idEsporte, fn ($w) => $w->where('idEsporte', $idEsporte));

    if ($search) {
        $q->where(function ($w) use ($search) {
            $w->where('nomePosicao', 'like', "%{$search}%")
              ->orWhereHas('esporte', function ($qq) use ($search) {
                  $qq->where('nomeEsporte', 'like', "%{$search}%");
              });
        });
    }

    $posicoes = $q
        ->orderByDesc('id')
        ->paginate($perPage);

    return response()->json($posicoes, 200);
}

    public function storePosicao(Request $request)
    {
        $data = $request->validate([
            'nomePosicao' => 'required|string|max:255',
            'idEsporte'   => 'required|exists:esportes,id', // sua FK na tabela posicoes
        ]);
        $posicao = Posicao::create($data);
        return response()->json($posicao, 201);
    }

    public function updatePosicao(Request $request, $id)
    {
        $posicao = Posicao::findOrFail($id);
        $data = $request->validate([
            'nomePosicao' => 'sometimes|required|string|max:255',
            'idEsporte'   => 'sometimes|required|exists:esportes,id',
        ]);
        $posicao->update($data);
        return response()->json($posicao);
    }

    public function destroyPosicao($id)
    {
        $posicao = Posicao::findOrFail($id);
        $posicao->delete();
        return response()->json(['ok' => true]);
    }

    public function UsuarioDestroy(string $id)
{
    $usuario = Usuario::find($id);

    if (!$usuario instanceof Usuario) {
        return response()->json(['message' => 'Usuário não encontrado'], 404);
    }

  
    $fotoPerfilPath = $usuario->getRawOriginal('fotoPerfilUsuario');
    if ($fotoPerfilPath) {
        Storage::disk('public')->delete($fotoPerfilPath);
        $usuario->fotoPerfilUsuario = null;
    }

    $fotoBannerPath = $usuario->getRawOriginal('fotoBannerUsuario');
    if ($fotoBannerPath) {
        Storage::disk('public')->delete($fotoBannerPath);
        $usuario->fotoBannerUsuario = null;
    }


    $suffix = '#deleted#' . $usuario->id . '#' . now()->timestamp;

    if ($usuario->emailUsuario) {
        $usuario->emailUsuario = $usuario->emailUsuario . $suffix;
    }

  
    if (defined(Usuario::class . '::STATUS_DELETADO')) {
        $usuario->status = Usuario::STATUS_DELETADO;
    }

    $usuario->save();

    return response()->json(['message' => 'Usuário marcado como deletado com sucesso'], 200);
}


    public function ClubeDestroy(string $id)
{
    $clube = Clube::find($id);

    if (!$clube instanceof Clube) {
        return response()->json(['message' => 'Clube não encontrado'], 404);
    }

    $fotoPerfilPath = $clube->getRawOriginal('fotoPerfilClube');
    if ($fotoPerfilPath) {
        Storage::disk('public')->delete($fotoPerfilPath);
        $clube->fotoPerfilClube = null;
    }

    $fotoBannerPath = $clube->getRawOriginal('fotoBannerClube');
    if ($fotoBannerPath) {
        Storage::disk('public')->delete($fotoBannerPath);
        $clube->fotoBannerClube = null;
    }

   
    $suffix = '#deleted#' . $clube->id . '#' . now()->timestamp;

    $clube->nomeClube  = $clube->nomeClube  . $suffix;
    $clube->cnpjClube  = $clube->cnpjClube  . $suffix;
    $clube->emailClube = $clube->emailClube . $suffix;

    // 3) Marcar status como deletado
    if (defined(Clube::class . '::STATUS_DELETADO')) {
        $clube->status = Clube::STATUS_DELETADO;
    }

    $clube->save();

    return response()->json(['message' => 'Clube marcado como deletado com sucesso'], 200);
}


    public function OportunidadeDestroy(string $id){
        $oportunidade = Oportunidade::find($id);
        if (!$oportunidade instanceof Oportunidade) {
            return response()->json(['message' => 'Oportunidade não encontrada'], 404);
        }
        $oportunidade->delete();
        return response()->json(['message' => 'Oportunidade deletada com sucesso'], 200);
    }

    public function clubeUpdate(Request $request, $id){
        $clube = Clube::find($id);
        if(!$clube instanceof Clube){
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $clube->update($request->all());
        return response()->json($clube, 200);
    }

    public function usuarioUpdate(Request $request, $id){
        $usuario = Usuario::find($id);
        if(!$usuario instanceof Usuario){
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $usuario->update($request->all());
        return response()->json($usuario, 200);
    }

    public function oportunidadeUpdate(Request $request, $id){
        $oportunidade = Oportunidade::find($id);
        if(!$oportunidade instanceof Oportunidade){
            return response()->json(['message' => 'Oportunidade não encontrada'], 404);
        }

        $oportunidade->update($request->all());
        return response()->json($oportunidade, 200);
    }

    public function listPending(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $search  = $request->query('search');

        $q = Oportunidade::pending()
            ->with(['esporte', 'posicao', 'clube']);

        if ($search) {
            $q->where(function ($w) use ($search) {
                $w->where('tituloOportunidades', 'like', "%{$search}%")
                ->orWhereHas('clube', function ($qq) use ($search) {
                    $qq->where('nomeClube', 'like', "%{$search}%");
                })
                ->orWhereHas('esporte', function ($qq) use ($search) {
                    $qq->where('nomeEsporte', 'like', "%{$search}%");
                });
            });
        }

        $oportunidades = $q
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return response()->json($oportunidades, 200);
    }

    public function aproved(Request $request, $id){
        $admin = $request->user();
        if (!$admin || !($admin instanceof Admin)) {
            return response()->json(['message' => 'Somente admin autenticado'], 403);
        }
        $opp = Oportunidade::find($id);
        if (!$opp) return response()->json(['message' => 'Oportunidade não encontrada'], 404);

        $opp->update([
            'status'         => Oportunidade::STATUS_APPROVED,
            'reviewed_by'    => $admin->id,
            'reviewed_at'    => now(),
            'rejection_reason' => null,
        ]);

        event(new OpportunityStatusChangeEvent($opp->clube, $opp, Oportunidade::STATUS_APPROVED));

        return response()->json(['message' => 'Oportunidade aprovada'], 200);
    }
    
    public function ListOportunidades(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $search  = $request->query('search');

        $q = Oportunidade::rejected()
            ->orWhere('status', Oportunidade::STATUS_APPROVED)
            ->with(['esporte', 'posicao', 'clube']);

        if ($search) {
            $q->where(function ($w) use ($search) {
                $w->where('tituloOportunidades', 'like', "%{$search}%")
                ->orWhereHas('clube', function ($qq) use ($search) {
                    $qq->where('nomeClube', 'like', "%{$search}%");
                })
                ->orWhereHas('esporte', function ($qq) use ($search) {
                    $qq->where('nomeEsporte', 'like', "%{$search}%");
                });
            });
        }

        $oportunidadesAdm = $q
            ->orderByDesc('created_at')
            ->paginate($perPage);

        return response()->json($oportunidadesAdm, 200);
    }

    public function reject(Request $request, $id){
        $admin = $request->user();
        if (!$admin || !($admin instanceof Admin)) {
            return response()->json(['message' => 'Somente admin autenticado'], 403);
        }
        $opp = Oportunidade::find($id);
        if (!$opp) return response()->json(['message' => 'Oportunidade não encontrada'], 404);

        $validatedData = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $opp->update([
            'status'         => Oportunidade::STATUS_REJECTED,
            'reviewed_by'    => $admin->id,
            'reviewed_at'    => now(),
            'rejection_reason' => $validatedData['rejection_reason'],
        ]);

        event(new OpportunityStatusChangeEvent($opp->clube, $opp, Oportunidade::STATUS_REJECTED));

        return response()->json(['message' => 'Oportunidade rejeitada'], 200);
    }

    public function listarCaracteristicasId($id)
    {
        try {
            $caracteristica = Caracteristica::findOrFail($id);
            return response()->json($caracteristica, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao listar caracteristicas',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeCaracteristica(Request $request)
    {
        $data = $request->validate([
            'caracteristica' => 'required|string|max:255',
            'esporte_id'   => 'required|exists:esportes,id',
            'unidade_medida' => 'required|string|max:255',
        ]);
        $caracteristica = Caracteristica::create($data);
        return response()->json($caracteristica, 201);
    }

    public function updateCaracteristica(Request $request, $id)
    {
        $caracteristica = Caracteristica::findOrFail($id);

        $data = $request->validate([
            'caracteristica' => 'sometimes|string|max:255',
            'esporte_id'   => 'sometimes|exists:esportes,id',
            'unidade_medida' => 'sometimes|string|max:255',
        ]);

        $caracteristica->update($data);
        return response()->json($caracteristica);
    }

    public function destroyCaracteristica($id)
    {
        $caracteristica = Caracteristica::findOrFail($id);
        $caracteristica->delete();
        return response()->json(['ok' => true]);
    }

    public function deletarFuncoes(Request $request, $id){
        $funcao = Funcao::find($id);
        if (!$funcao) {
            return response()->json(['message' => 'Função não encontrada'], 404);
        }
        $funcao->status = Funcao::STATUS_DELETADO;
        $funcao->save();
        return response()->json(['message' => 'Função deletada com sucesso'], 200);
        }

    public function listarFuncoes(Request $request)
{
    $status  = $request->query('status');
    $search  = $request->query('search');
    $perPage = (int) $request->query('per_page', 15);

    $sortCol = $request->query('sort_col');
    $sortDir = $request->query('sort_dir');

    $q = Funcao::query();

    if ($status) {
        $q->where('status', $status);
    }

    if ($search) {
        $q->where(function ($w) use ($search) {
            $w->where('nome', 'like', "%{$search}%")
              ->orWhere('descricao', 'like', "%{$search}%");
        });
    }

    $allowedColumns = ['id', 'nome', 'descricao', 'status', 'created_at'];

    if (
        $sortCol && 
        in_array($sortCol, $allowedColumns) && 
        in_array($sortDir, ['asc', 'desc'])
    ) {
        $q->orderBy($sortCol, $sortDir);
    } else {
        $q->orderBy('id', 'desc');
    }

    $funcoes = $q->paginate($perPage);

    return response()->json($funcoes, 200);
}

    public function ativarFuncoes(Request $request, $id){
        $funcao = Funcao::find($id);
        if (!$funcao) {
            return response()->json(['message' => 'Função não encontrada'], 404);
        }
        $funcao->status = Funcao::STATUS_ATIVO;
        $funcao->save();
        return response()->json(['message' => 'Função ativada com sucesso'], 200);
    }

    public function esporteAtivar(Request $request, $id){
        $esporte = Esporte::find($id);
        if (!$esporte) {
            return response()->json(['message' => 'Esporte não encontrado'], 404);
        }
        $esporte->status = Esporte::STATUS_ATIVO;
        $esporte->save();
        return response()->json(['message' => 'Esporte ativado com sucesso'], 200);
    }
    public function esporteDeletar(Request $request, $id){
        $esporte = Esporte::find($id);
        if (!$esporte) {
            return response()->json(['message' => 'Esporte não encontrado'], 404);
        }
        $esporte->status = Esporte::STATUS_DELETADO;
        $esporte->save();
        return response()->json(['message' => 'Esporte deletado com sucesso'], 200);
    }
    public function listaAtivar(Request $request, $id){
        $lista = Lista::find($id);
        if (!$lista) {
            return response()->json(['message' => 'Lista não encontrada'], 404);
        }
        $lista->status = Lista::STATUS_ATIVO;
        $lista->save();
        return response()->json(['message' => 'Lista ativada com sucesso'], 200);
    }
    public function listaDeletar(Request $request, $id){
        $lista = Lista::find($id);
        if (!$lista) {
            return response()->json(['message' => 'Lista não encontrada'], 404);
        }
        $lista->status = Lista::STATUS_DELETADO;
        $lista->save();
        return response()->json(['message' => 'Lista deletada com sucesso'], 200);
    }
}