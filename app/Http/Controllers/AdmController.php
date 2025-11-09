<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Caracteristica;
use App\Models\Oportunidade;
use App\Models\Usuario;
use App\Models\Clube;
use App\Models\Categoria;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Esporte;
use App\Models\Funcao;
use App\Models\Posicao; 
use Illuminate\Validation\Rule;

class AdmController extends Controller
{

    public function showProfilePage(Request $request) {
        $admin = Admin::findOrFail(1); // Tem que arrumar depois do login isso aqui, deveria pegar da autenticação

        return view('admin.perfil')->with(
            ['admin' => $admin]
        );
    }
    
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
            return response()->json($esportes->load('posicoes', 'caracteristicas'), 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao listar esportes',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function ListarEsportesId($id)
    {
        try {
            $esporte = Esporte::findOrFail($id);
            return response()->json($esporte->load('posicoes', 'caracteristicas'), 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao listar esportes',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function ListarEsportesWeb()
    {
        try {
            $esportes = Esporte::all();
            return view('admin.esportes')->with([
                'esportes' => $esportes->load('posicoes', 'caracteristicas')
            ]);
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
        return response()->json($esporte->load('posicoes', 'caracteristicas'), 201);
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
    public function listarCategorias()
    {
        try {
            $categorias = Categoria::all();
            return response()->json($categorias, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao listar categorias',
                'message' => $e->getMessage()
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
        return response()->json($esporte->load('posicoes', 'caracteristicas'), 200);
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

    public function listarPosicoesId($id)
    {
        try {
            $posicao = Posicao::findOrFail($id);
            return response()->json($posicao, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao listar posições',
                'message' => $e->getMessage()
            ], 500);
        }
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

    public function showPosicoesByEsporte(Request $request, $id)
    {
        $esporte = Esporte::findOrFail($id);

        return $esporte->posicoes;
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

    public function UsuarioDestroy(string $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario instanceof Usuario) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }
        $usuario->delete();
        return response()->json(['message' => 'Usuário deletado com sucesso'], 200);
    }
    public function ClubeDestroy(string $id)
    {
        $clube = Clube::find($id);
        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }
        $clube->delete();
        return response()->json(['message' => 'Clube deletado com sucesso'], 200);
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

    public function listPending(Request $request){
        $perPage = $request->query('per_page', 15);
        $oportunidades = Oportunidade::pending()
        ->with(['esporte', 'posicao', 'clube'])
        ->orderBy('created_at')
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

        return response()->json(['message' => 'Oportunidade aprovada'], 200);
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

        return response()->json(['message' => 'Oportunidade rejeitada'], 200);
    }
}
