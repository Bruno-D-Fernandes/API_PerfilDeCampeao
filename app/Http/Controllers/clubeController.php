<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Clube;
use App\Models\Esporte;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ClubeController extends Controller
{
    public function showWebPage()
    {
        $clubes = Clube::all()->load('esporte', 'categoria');
        $esportes = Esporte::all();
        $categorias = Categoria::all();

        return view('admin.clubes')->with(['clubes' => $clubes, 'esportes' => $esportes, 'categorias' => $categorias]);
    }

    // Listar todos os clubes
    public function index()
    {
        $clubes = Clube::all();
        return response()->json($clubes);
    }

    // Criar um novo clube
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomeClube' => 'required|string|max:255|unique:clubes,nomeClube',
                'cnpjClube' => 'required|string|max:20|unique:clubes,cnpjClube',
                'emailClube' => 'required|string|max:255|unique:clubes,emailClube',
                'cidadeClube' => 'required|string|max:255',
                'estadoClube' => 'required|string|max:255',
                'anoCriacaoClube' => 'required|date',
                'enderecoClube' => 'required|string|max:255',
                'bioClube' => 'nullable|string',
                'senhaClube' => 'required|string|min:6',
                'categoria_id' => 'required|exists:categorias,id',
                'esporte_id' => 'required|exists:esportes,id',
                'fotoPerfilClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
                'fotoBannerClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048'
            ]);

            $caminhoFotoPerfil = null;
            $caminhoFotoBanner = null;

            if ($request->hasFile('fotoPerfilClube')) {
                $caminhoFotoPerfil = $request->file('fotoPerfilClube')->store('clubes/perfis', 'public');
            }

            if ($request->hasFile('fotoBannerClube')) {
                $caminhoFotoBanner = $request->file('fotoBannerClube')->store('clubes/banners', 'public');
            }

            Clube::create([
                'nomeClube' => $validatedData['nomeClube'],
                'cnpjClube' => $validatedData['cnpjClube'],
                'emailClube' => $validatedData['emailClube'],
                'cidadeClube' => $validatedData['cidadeClube'],
                'estadoClube' => $validatedData['estadoClube'],
                'anoCriacaoClube' => $validatedData['anoCriacaoClube'],
                'enderecoClube' => $validatedData['enderecoClube'],
                'bioClube' => $validatedData['bioClube'] ?? null,
                'senhaClube' => Hash::make($validatedData['senhaClube']),
                'fotoPerfilClube' => $caminhoFotoPerfil,
                'fotoBannerClube' => $caminhoFotoBanner,
                'categoria_id' => $validatedData['categoria_id'],
                'esporte_id' => $validatedData['esporte_id'],
            ]);

            $authController = new AuthClubeController();
            return $authController->login($request);

        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeByAdmin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomeClube' => 'required|string|max:255|unique:clubes,nomeClube',
                'cnpjClube' => 'required|string|max:20|unique:clubes,cnpjClube',
                'emailClube' => 'required|string|max:255|unique:clubes,emailClube',
                'cidadeClube' => 'required|string|max:255',
                'estadoClube' => 'required|string|max:255',
                'anoCriacaoClube' => 'required|date',
                'enderecoClube' => 'required|string|max:255',
                'bioClube' => 'nullable|string',
                'categoria_id' => 'required|exists:categorias,id',
                'esporte_id' => 'required|exists:esportes,id',
                'fotoPerfilClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
                'fotoBannerClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048'
            ]);

            $caminhoFotoPerfil = null;
            $caminhoFotoBanner = null;

            if ($request->hasFile('fotoPerfilClube')) {
                $caminhoFotoPerfil = $request->file('fotoPerfilClube')->store('clubes/perfis', 'public');
            }

            if ($request->hasFile('fotoBannerClube')) {
                $caminhoFotoBanner = $request->file('fotoBannerClube')->store('clubes/banners', 'public');
            }

            $senhaTemporariaAleatoria = Str::random(16);

            $clube = Clube::create([
                'nomeClube' => $validatedData['nomeClube'],
                'cnpjClube' => $validatedData['cnpjClube'],
                'emailClube' => $validatedData['emailClube'],
                'cidadeClube' => $validatedData['cidadeClube'],
                'estadoClube' => $validatedData['estadoClube'],
                'anoCriacaoClube' => $validatedData['anoCriacaoClube'],
                'enderecoClube' => $validatedData['enderecoClube'],
                'bioClube' => $validatedData['bioClube'] ?? null,
                'senhaClube' => Hash::make($senhaTemporariaAleatoria),
                'fotoPerfilClube' => $caminhoFotoPerfil,
                'fotoBannerClube' => $caminhoFotoBanner,
                'categoria_id' => $validatedData['categoria_id'],
                'esporte_id' => $validatedData['esporte_id'],
            ]);

            return response()->json($clube->load('categoria', 'esporte'), 201);

        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Mostrar um clube específico
    public function show($id)
    {
        try {
            $clube = Clube::findOrFail($id);

            $utilizadorAutenticado = Auth::user();
            $podeVer = false;

            if ($utilizadorAutenticado instanceof Admin) {
                $podeVer = true;
            } elseif ($utilizadorAutenticado instanceof Clube && $utilizadorAutenticado->id == $clube->id) {
                $podeVer = true;
            }

            if (!$podeVer) {
                Log::warning('Acesso negado ao clube show', [
                    'autenticado_id' => $utilizadorAutenticado ? $utilizadorAutenticado->id : null,
                    'autenticado_tipo' => $utilizadorAutenticado ? get_class($utilizadorAutenticado) : 'Nenhum utilizador autenticado',
                    'clube_solicitado_id' => $clube->id
                ]);
                return response()->json(['message' => 'Acesso não autorizado'], 403);
            }

            return response()->json($clube->load('categoria', 'esporte'), 200);

        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Atualizar um clube
    public function update(Request $request, $id)
    {
        try {
            $clube = Clube::findOrFail($id);

            $validatedData = $request->validate([
                'nomeClube' => 'sometimes|string|max:255',
                'cnpjClube' => ['sometimes', 'string', 'max:20', Rule::unique('clubes', 'cnpjClube')->ignore($clube->id)],
                'emailClube' => ['sometimes', 'string', 'max:255', Rule::unique('clubes', 'emailClube')->ignore($clube->id)],
                'cidadeClube' => 'sometimes|string|max:255',
                'estadoClube' => 'sometimes|string|max:255',
                'anoCriacaoClube' => 'sometimes|date',
                'enderecoClube' => 'sometimes|string|max:255',
                'bioClube' => 'nullable|string',
                'senhaClube' => 'sometimes|string|min:6|confirmed',
                'categoria_id' => 'sometimes|exists:categorias,id',
                'esporte_id' => 'sometimes|exists:esportes,id',
                'fotoPerfilClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
                'fotoBannerClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
            ]);

            $clube->fill($validatedData);
            
            if ($request->filled('senhaClube')) {
                $clube->senhaClube = Hash::make($validatedData['senhaClube']);
            }

            if ($request->hasFile('fotoPerfilClube')) {
                $caminhoAntigo = $clube->getRawOriginal('fotoPerfilClube');
                if ($caminhoAntigo) {
                    Storage::disk('public')->delete($caminhoAntigo);
                }
                $clube->fotoPerfilClube = $request->file('fotoPerfilClube')->store('clubes/perfis', 'public');
            }

            if ($request->hasFile('fotoBannerClube')) {
                $caminhoAntigo = $clube->getRawOriginal('fotoBannerClube');
                if ($caminhoAntigo) {
                    Storage::disk('public')->delete($caminhoAntigo);
                }
                $clube->fotoBannerClube = $request->file('fotoBannerClube')->store('clubes/banners', 'public');
            }

            $clube->save();

            return response()->json($clube->fresh()->load('categoria', 'esporte'), 200);

        } catch(\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao atualizar o clube',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Deletar um clube
    public function destroy($id)
    {
        try {
            $clube = Clube::findOrFail($id);

            $caminhoFotoPerfil = $clube->getRawOriginal('fotoPerfilClube');
            if ($caminhoFotoPerfil) {
                Storage::disk('public')->delete($caminhoFotoPerfil);
            }

            $caminhoFotoBanner = $clube->getRawOriginal('fotoBannerClube');
            if ($caminhoFotoBanner) {
                Storage::disk('public')->delete($caminhoFotoBanner);
            }

            $clube->delete();

            return response()->json(null, 204);

        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
