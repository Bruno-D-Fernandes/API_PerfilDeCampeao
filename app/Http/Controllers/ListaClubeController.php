<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lista;
use App\Models\Clube;
use App\Models\Usuario;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class ListaClubeController extends Controller
{
    public function showWebPage()
    {
        $listas = Lista::with('clube', 'usuarios')->get();

        return view('admin.listas.listas')->with(['listas' => $listas]);
    }

    public function index(Request $request)
    {
        try {
            $clube = $request->user();

            if (! $clube instanceof Clube) {
                return response()->json(['message' => 'Clube não autenticado'], 401);
            }

            $search  = $request->query('search');
            $perPage = (int) $request->query('per_page', 15);
            $sortCol = $request->query('sort_col');
            $sortDir = $request->query('sort_dir');

            $q = Lista::query()
                ->where('clube_id', $clube->id)
                ->withCount('usuarios');

            if ($search) {
                $q->where(function ($w) use ($search) {
                    $w->where('nome', 'like', "%{$search}%")
                      ->orWhere('descricao', 'like', "%{$search}%");
                });
            }

            $allowedColumns = [
                'id',
                'nome',
                'descricao',
                'usuarios_count',
                'created_at',
                'updated_at',
            ];

            if (
                $sortCol &&
                in_array($sortCol, $allowedColumns) &&
                in_array($sortDir, ['asc', 'desc'])
            ) {
                $q->orderBy($sortCol, $sortDir);
            } else {
                $q->orderBy('id', 'desc');
            }

            $listas = $q->paginate($perPage);

            return response()->json($listas, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao buscar listas',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // POST /api/clube/listas
    public function store(Request $request)
    {
        $clube = $request->user();

        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Apenas clube autenticado'], 403);
        }

        $data = $request->validate([
            'nome'       => 'required|string|max:255',
            'descricao'  => 'nullable|string|max:255',
        ]);

        $existe = Lista::where('clube_id', $clube->id)->where('nome', $data['nome'])->exists();

        if ($existe) {
            return response()->json(['message' => 'Já existe uma lista com esse nome'], 422);
        }

        $lista = Lista::create([
            'clube_id'  => $clube->id,
            'nome'      => $data['nome'],
            'descricao' => $data['descricao'] ?? null,
        ]);

        $htmlGrid = view('clube.partials.list-card', ['item' => $lista])->render();

        $htmlModal = view('clube.partials.save-to-list-item', ['lista' => $lista])->render();

        return response()->json([
            'message' => 'Lista criada com sucesso', 
            'data' => $lista, 
            'html' => $htmlGrid,       
            'html_modal' => $htmlModal 
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $lista = Lista::findOrFail($id);
        
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $lista->update($validated);

        return response()->json([
            'message' => 'Lista atualizada!',
            'data'    => $lista
        ], 200);
    }
    
    // POST /api/clube/listas/{listaId}/usuarios
    public function addUsuarioToLista(Request $request, $listaId, Usuario $usuario)
    {
        $clube = $request->user();

        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Apenas clube autenticado'], 403);
        }

        $lista = Lista::where('clube_id', $clube->id)->findOrFail($listaId);

        $lista->usuarios()->syncWithoutDetaching($usuario);

        return response()->json(['message' => 'Usuário adicionado à lista com sucesso'], 201);
    }

    // DELETE /api/clube/listas/{listaId}/usuarios
    public function removeUsuarioFromLista(Request $request, $listaId, Usuario $usuario)
    {
        $clube = $request->user();

        if (!$clube instanceof Clube) {
            return response()->json(['message' => 'Apenas clube autenticado'], 403);
        }

        $lista = Lista::where('clube_id', $clube->id)->findOrFail($listaId);
        $lista->usuarios()->detach($usuario);

        return response()->json(['message' => 'Usuário removido da lista com sucesso'], 200);
    }

    // GET /api/clube/listas/{id}
    public function show(Request $request, $id)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        $lista = Lista::with([
            'clube',
            'usuarios:id,nomeCompletoUsuario,emailUsuario,estadoUsuario,cidadeUsuario,alturaCm,pesoKg'
        ])->find($id);

        if (!$lista) {
            return response()->json(['message' => 'Lista não encontrada'], 404);
        }

        $podeVer = false;

        if ($user instanceof Admin) {
            $podeVer = true;
        } elseif ($user instanceof Clube && $user->id == $lista->clube_id) {
            $podeVer = true;
        }

        if (!$podeVer) {
            return response()->json(['message' => 'Você não tem permissão para ver esta lista'], 403);
        }

        return response()->json($lista);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        $lista = Lista::find($id);

        if (!$lista) {
            return response()->json(['message' => 'Lista não encontrada'], 404);
        }

        $podeExcluir = false;

        if ($user instanceof Admin) {
            $podeExcluir = true;
        } elseif ($user instanceof Clube && $user->id == $lista->clube_id) {
            $podeExcluir = true;
        }

        if (!$podeExcluir) {
            return response()->json(['message' => 'Você não tem permissão para excluir esta lista'], 403);
        }

        try {
            $lista->usuarios()->detach();

            $lista->delete();

            return response()->json(['message' => 'Lista excluída com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro interno ao excluir a lista',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
