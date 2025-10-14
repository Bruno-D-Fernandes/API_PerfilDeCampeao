<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clube;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ClubeController extends Controller
{
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
                'senhaClube' => 'required|string|min:6|confirmed',
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
            ]);

            $authController = new AuthClubeController();
            return $authController->login($request);

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
            $clube = Clube::find($id);

            if(!$clube){
                return response()->json(['message' => 'Clube não encontrado'], 404);
            }

            return response()->json($clube, 200);

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
            $clube = Clube::find($id);

            if (!$clube) {
                return response()->json(['message' => 'Clube não encontrado'], 404);
            }

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
                'fotoPerfilClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
                'fotoBannerClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048'
            ]);

            $clube->fill($validatedData);

            if ($request->filled('senhaClube')) {
                $clube->senhaClube = Hash::make($validatedData['senhaClube']);
            }

            if ($request->hasFile('fotoPerfilClube')) {
                if ($clube->fotoPerfilClube) {
                    Storage::disk('public')->delete($clube->getRawOriginal('fotoPerfilClube'));
                }

                $clube->fotoPerfilClube = $request->file('fotoPerfilClube')->store('clubes/perfis', 'public');
            }

            if ($request->hasFile('fotoBannerClube')) {
                if ($clube->fotoBannerClube) {
                    Storage::disk('public')->delete($clube->getRawOriginal('fotoBannerClube'));
                }

                $clube->fotoBannerClube = $request->file('fotoBannerClube')->store('clubes/banners', 'public');
            }

            $clube->save();

            return response()->json($clube->fresh(), 200);

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
            $clube = Clube::find($id);

            if (!$clube) {
                return response()->json(['message' => 'Clube não encontrado'], 404);
            }

            if ($clube->fotoPerfilClube) {
                Storage::disk('public')->delete($clube->getRawOriginal('fotoPerfilClube'));
            }

            if ($clube->fotoBannerClube) {
                Storage::disk('public')->delete($clube->getRawOriginal('fotoBannerClube'));
            }

            $clube->delete();

            return response()->json(['message' => 'Clube deletado com sucesso'], 200);

        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
