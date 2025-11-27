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

class AdminSistemaController extends Controller
{


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