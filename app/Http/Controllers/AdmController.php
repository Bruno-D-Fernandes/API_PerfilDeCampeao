<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Esporte;
use App\Models\Funcao;
use App\Models\Posicao; 
use Illuminate\Validation\Rule;

class AdmController extends Controller
{
     public function loginAdm(Request $request)
    {
        try {
            $user = Admin::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }

            $token = $user->createToken('auth_token', ['adm'], null, 'adm_sanctum')->plainTextToken;

            return response()->json([
            'access_token' => "Bearer $token"
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro durante o login',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function perfilAdm(Request $request)
        {
            try {
                return response()->json($request->user(), 200);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Ocorreu um erro ao buscar o perfil',
                    'message' => $e->getMessage()
                ], 500);
            }
        }

        public function logoutAdm(Request $request)
        {
            try {
                $request->user()->currentAccessToken()->delete();
                return response()->json(['message' => 'Logout realizado com sucesso'], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Ocorreu um erro durante o logout',
                    'message' => $e->getMessage()
                ], 500);
            }
        }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ListarEsportes()
    {
        try {
            $esportes = Esporte::all();
            return response()->json($esportes, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao listar esportes',
                'message' => $e->getMessage()
            ], 500);
        }
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
        return response()->json($esporte, 200);
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

    public function listarPosicoes(Request $request){
        $idEsporte = $request->query('idEsporte');
        $q = Posicao::with('esporte:id,nomeEsporte')
            ->when($idEsporte, fn($w) => $w->where('idEsporte', $idEsporte))
            ->orderByDesc('id');

        return response()->json($q->get());
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

    /* Adicionando função aqui (Esse controller fere todos os príncipios de responsabilidade e POO) */

    public function storeFuncao(Request $request) 
    {
        try {
            $validatedData = $request->validate([
                'nomeFuncao' => 'required|unique:funcoes|string|max:100',
                'descricaoFuncao' => 'nullable|string|max:255',
            ]);

            $funcao = Funcao::create([
                'nomeFuncao' => $validatedData['nomeFuncao'],
                'descricaoFuncao' => $validatedData['descricaoFuncao'] ?? null
            ]);

            return response()->json($funcao, 201);
        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Erro ao cadastrar função',
                'message' => $e->getMessage()
            ], 500);  
        }
    }

    public function listarFuncoes(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $funcoes = Funcao::latest()->paginate($perPage);

        return response()->json($funcoes);
    }

    public function updateFuncao(Request $request, string $id)
    {
        try {
            $funcao = Funcao::findOrFail($id);

            $validatedData = $request->validate([
                'nomeFuncao' => ['sometimes', 'string', 'max:255', Rule::unique('funcoes', 'nomeFuncao')->ignore($funcao->id)],
                'descricaoFuncao'   => 'nullable|string|max:255',
            ]);

            $funcao->update($validatedData);

            return response()->json($funcao->fresh(), 200);
        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Erro ao atualizar função',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyFuncao(Request $request, string $id)
    {
        try {
            $funcao = Funcao::findOrFail($id);
            $funcao->delete();
            return response()->json(null, 204);
        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Erro ao deletar a função',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
