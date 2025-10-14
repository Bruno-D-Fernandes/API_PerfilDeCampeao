<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clube;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Inscricao;
use App\Models\Oportunidade;

class AuthClubeController extends Controller
{
    
    public function login(Request $request)
    {
        $clube = Clube::where('cnpjClube', $request->cnpjClube)->first();

        if (! $clube || ! Hash::check($request->senhaClube, $clube->senhaClube)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        $token = $clube->createToken('auth_token', ['club'], null, 'club_sanctum')->plainTextToken;

        return response()->json([
           'access_token' => "Bearer $token"
        ]);
    }

    public function perfil(Request $request)
    {
        return response()->json($request->user(), 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    public function deleteAccount(Request $request)
    {
        $clube = $request->user();

        if (!$clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $clube->delete();

        return response()->json(['message' => 'Conta do clube excluida com sucesso'], 200);
    }
    public function updateAccount(Request $request)
    {
        $clube = $request->user();

        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nomeClube' => 'sometimes|required|string|max:255',
            'cidadeClube' => 'sometimes|required|string|max:255',
            'estadoClube' => 'sometimes|required|string|max:255',
            'anoCriacaoClube' => 'sometimes|required|date',
            'cnpjClube' => 'sometimes|required|string|max:20|unique:clubes,cnpjClube,' . $clube->id,
            'enderecoClube' => 'sometimes|required|string|max:255',
            'bioClube' => 'nullable|string',
            'senhaClube' => 'sometimes|required|string|min:6|confirmed',
        ]);

        if (isset($validatedData['senhaClube'])) {
            $validatedData['senhaClube'] = Hash::make($validatedData['senhaClube']);
        }

        $clube->update($validatedData);

        return response()->json($clube, 200);
    }


    public function accept (Request $request, $inscricaoId)
    {
        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube)) {
            return response()->json(['message' => 'Somente clube autenticado'], 403);
        }

        $insc = Inscricao::findOrFail($inscricaoId);
        $op = Oportunidade::findOrFail($insc->oportunidade_id);
        if ($op->clube_id !== $clube->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $insc->status = Inscricao::STATUS_APPROVED;
        $insc->reviewed_by = $clube->id;
        $insc->reviewed_at = now();
        $insc->save();

        return response()->json(['ok' => true]);
    }

    public function reject (Request $request, $inscricaoId)
    {
        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube)) {
            return response()->json(['message' => 'Somente clube autenticado'], 403);
        }

        $insc = Inscricao::findOrFail($inscricaoId);
        $op = Oportunidade::findOrFail($insc->oportunidade_id);
        if ($op->clube_id !== $clube->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $insc->status = Inscricao::STATUS_REJECTED;
        $insc->reviewed_by = $clube->id;
        $insc->reviewed_at = now();
        $insc->save();

        return response()->json(['ok' => true]);
    }

    public function inscritosClube(Request $request, $oportunidadeId)
{
    $clube = $request->user();
    if (!$clube || !($clube instanceof Clube)) {
        return response()->json(['message' => 'Somente clube autenticado'], 403);
    }

    try {
        $op = Oportunidade::with(['esporte:id,nomeEsporte','posicoes:id,nomePosicao'])
            ->findOrFail($oportunidadeId);

        if ($op->clube_id !== $clube->id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $perPage = (int) $request->query('per_page', 30);
        $status  = $request->query('status');

        $inscritos = Inscricao::with([
                'usuario:id,nomeCompletoUsuario,emailUsuario,estadoUsuario,cidadeUsuario,dataNascimentoUsuario,alturaCm,pesoKg'
            ])
            ->where('oportunidade_id', $op->id)
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate($perPage);

        $mapped = $inscritos->getCollection()->map(function ($row) use ($op) {
            $u = $row->usuario;
            return [
                'inscricao_id' => $row->id,
                'usuario_id'   => $u->id,
                'nome'         => $u->nomeCompletoUsuario,
                'modalidade'   => $op->esporte?->nomeEsporte,
                // ajuste aqui também se sua relação for 'posicao' singular
                'posicao'      => $op->posicao?->nomePosicao,
                'local'        => trim(($u->cidadeUsuario ? $u->cidadeUsuario.' - ' : '').($u->estadoUsuario ?? '')),
                'idade'        => $u->dataNascimentoUsuario ? Carbon::parse($u->dataNascimentoUsuario)->age.' anos' : null,
                'status'       => $row->status,
                'reviewed_at'  => $row->reviewed_at,
            ];
        });

        $inscritos->setCollection($mapped);

        return response()->json($inscritos);

    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Oportunidade não encontrada'], 404);
    } catch (\Throwable $e) {
        return response()->json([
            'message' => 'Erro ao listar inscritos',
            'error'   => $e->getMessage(),
        ], 500);
    }
}

    public function myOportunidadesClube(Request $request)
    {
        $clube = $request->user();
        if (!$clube || !($clube instanceof Clube)) {
            return response()->json(['message' => 'Somente clube autenticado'], 403);
        }
        $per_page = (int)$request->query('per_page', 15);
        $per_page = max(1, min(100, $per_page));

        $status = $request->query('status');
        $states = [
            Oportunidade::STATUS_PENDING,
            Oportunidade::STATUS_APPROVED,
            Oportunidade::STATUS_REJECTED
        ];
        if ($status && !in_array($status, $states)) {
            return response()->json(['message' => 'Status inválido'], 400);
        }

        $q = Oportunidade::where('clube_id', $clube->id)
            ->with(['esporte','posicao'])
            ->orderByDesc('id');

        if($status){
            $q->where('status', $status);
        }
        return response()->json($q->paginate($per_page));
    }
    
    
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}