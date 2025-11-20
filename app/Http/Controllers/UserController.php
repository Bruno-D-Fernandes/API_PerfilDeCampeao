<?php

namespace App\Http\Controllers;

use App\Events\UserFollowedEvent;
use App\Events\ClubFollowedEvent;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthUserController;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function showProfilePage(Request $request, $id)
    {
        $usuario = Usuario::with([
            'perfis.esporte',
            'perfis.posicoes',
            'perfis.caracteristicas',
        ])->findOrFail($id);

        return view('clube.perfis.usuarios', [
            'usuario' => $usuario
        ]);
    }

    public function showWebPage()
    {
        $usuarios = Usuario::all();

        return view('admin.listas.usuarios')->with(['usuarios' => $usuarios]);
    }

    // Listar todos os usuários
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    // Criar novo usuário
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomeCompletoUsuario' => 'required|string|max:255',
                'emailUsuario' => 'required|email|unique:usuarios,emailUsuario',
                'senhaUsuario' => 'required|string|min:3',
                'dataNascimentoUsuario' => 'required|date',
                'generoUsuario' => 'nullable|string|max:100',
                'estadoUsuario' => 'nullable|string|max:100',
                'cidadeUsuario' => 'nullable|string|max:100',
                'alturaCm' => 'nullable|numeric|min:50|max:300',
                'pesoKg' => 'nullable|numeric|min:20|max:500',
                'peDominante' => 'nullable|in:Direito,Esquerdo',
                'maoDominante' => 'nullable|in:Destro,Canhoto',
                'fotoPerfilUsuario' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
                'fotoBannerUsuario' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048'
            ]);

            $caminhoFotoPerfil = null;
            $caminhoFotoBanner = null;

            if ($request->hasFile('fotoPerfilUsuario')) {
                $caminhoFotoPerfil = $request->file('fotoPerfilUsuario')->store('usuarios/perfis', 'public');
            }

            if ($request->hasFile('fotoBannerUsuario')) {
                $caminhoFotoBanner = $request->file('fotoBannerUsuario')->store('usuarios/banners', 'public');
            }

            Usuario::create([
                'nomeCompletoUsuario' => $validatedData['nomeCompletoUsuario'],
                'emailUsuario' => $validatedData['emailUsuario'],
                'senhaUsuario' => Hash::make($validatedData['senhaUsuario']),
                'dataNascimentoUsuario' => $validatedData['dataNascimentoUsuario'],
                'generoUsuario' => $validatedData['generoUsuario'] ?? null,
                'estadoUsuario' => $validatedData['estadoUsuario'] ?? null,
                'cidadeUsuario' => $validatedData['cidadeUsuario'] ?? null,
                'status' => Usuario::STATUS_ATIVO,
                'alturaCm' => $validatedData['alturaCm'] ?? null,
                'pesoKg' => $validatedData['pesoKg'] ?? null,
                'peDominante' => $validatedData['peDominante'] ?? null,
                'maoDominante' => $validatedData['maoDominante'] ?? null,
                'fotoPerfilUsuario' => $caminhoFotoPerfil,
                'fotoBannerUsuario' => $caminhoFotoBanner,
            ]);

            $authController = new AuthUserController();
            return $authController->login($request);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeByAdmin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomeCompletoUsuario' => 'required|string|max:255',
                'emailUsuario' => 'required|email|unique:usuarios,emailUsuario',
                'dataNascimentoUsuario' => 'required|date',
                'generoUsuario' => 'nullable|string|max:100',
                'estadoUsuario' => 'nullable|string|max:100',
                'cidadeUsuario' => 'nullable|string|max:100',
                'alturaCm' => 'nullable|numeric|min:50|max:300',
                'pesoKg' => 'nullable|numeric|min:20|max:500',
                'peDominante' => 'nullable|in:Direito,Esquerdo',
                'maoDominante' => 'nullable|in:Destro,Canhoto',
                'fotoPerfilUsuario' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
                'fotoBannerUsuario' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048'
            ]);

            $senhaTemporariaAleatoria = Str::random(16);

            $usuario = Usuario::create([
                'nomeCompletoUsuario' => $validatedData['nomeCompletoUsuario'],
                'emailUsuario' => $validatedData['emailUsuario'],
                'senhaUsuario' => Hash::make($senhaTemporariaAleatoria),
                'dataNascimentoUsuario' => $validatedData['dataNascimentoUsuario'],
                'generoUsuario' => $validatedData['generoUsuario'] ?? null,
                'estadoUsuario' => $validatedData['estadoUsuario'] ?? null,
                'cidadeUsuario' => $validatedData['cidadeUsuario'] ?? null,
                'status' => Usuario::STATUS_ATIVO,
                'alturaCm' => $validatedData['alturaCm'] ?? null,
                'pesoKg' => $validatedData['pesoKg'] ?? null,
                'peDominante' => $validatedData['peDominante'] ?? null,
                'maoDominante' => $validatedData['maoDominante'] ?? null,
            ]);

            return response()->json($usuario, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $usuario = Usuario::find($id);
            if (!$usuario) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $validatedData = $request->validate([
                'nomeCompletoUsuario' => 'nullable|string|max:255',
                'emailUsuario' => 'nullable|email|unique:usuarios,emailUsuario,' . $id,
                'dataNascimentoUsuario' => 'nullable|date',
                'generoUsuario' => 'nullable|string|max:100',
                'estadoUsuario' => 'nullable|string|max:100',
                'cidadeUsuario' => 'nullable|string|max:100',
                'alturaCm' => 'nullable|numeric|min:50|max:300',
                'pesoKg' => 'nullable|numeric|min:20|max:500',
                'peDominante' => 'nullable|in:Direito,Esquerdo',
                'maoDominante' => 'nullable|in:Destro,Canhoto',

                'fotoPerfilUsuario' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg',
                'fotoBannerUsuario' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $dataToUpdate = $validatedData;

            if ($request->hasFile('fotoPerfilUsuario')) {
                if ($usuario->fotoPerfilUsuario) {
                    Storage::disk('public')->delete($usuario->fotoPerfilUsuario);
                }
                $perfilPath = $request->file('fotoPerfilUsuario')->store('perfil_fotos', 'public');
                $dataToUpdate['fotoPerfilUsuario'] = $perfilPath;
            }

            if ($request->hasFile('fotoBannerUsuario')) {
                if ($usuario->fotoBannerUsuario) {
                    Storage::disk('public')->delete($usuario->fotoBannerUsuario);
                }
                $bannerPath = $request->file('fotoBannerUsuario')->store('banner_fotos', 'public');
                $dataToUpdate['fotoBannerUsuario'] = $bannerPath;
            }

            $usuario->update($dataToUpdate);

            return response()->json($usuario, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao atualizar o usuário',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retorna os dados do usuário com as URLs completas das imagens.
     */
    public function show(string $id)
    {
        try {
            $usuario = Usuario::find($id);

            if (!$usuario) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $usuarioArray = $usuario->toArray();

            if (!empty($usuarioArray['fotoPerfilUsuario'])) {
                $usuarioArray['fotoPerfilUsuario'] = asset('storage/' . $usuarioArray['fotoPerfilUsuario']);
            } else {
                $usuarioArray['fotoPerfilUsuario'] = null;
            }

            if (!empty($usuarioArray['fotoBannerUsuario'])) {
                $usuarioArray['fotoBannerUsuario'] = asset('storage/' . $usuarioArray['fotoBannerUsuario']);
            } else {
                $usuarioArray['fotoBannerUsuario'] = null;
            }

            return response()->json($usuarioArray, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao buscar o usuário',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Deleta o usuário e suas imagens.
     */
    public function destroy(string $id)
    {
        try {
            $usuario = Usuario::find($id);

            if (!$usuario) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            if ($usuario->fotoPerfilUsuario) {
                Storage::disk('public')->delete($usuario->fotoPerfilUsuario);
            }

            if ($usuario->fotoBannerUsuario) {
                Storage::disk('public')->delete($usuario->fotoBannerUsuario);
            }

            if ($usuario->fotoPerfilUsuario) {
                Storage::disk('public')->delete($usuario->getRawOriginal('fotoPerfilUsuario'));
            }

            if ($usuario->fotoBannerUsuario) {
                Storage::disk('public')->delete($usuario->getRawOriginal('fotoBannerUsuario'));
            }

            $usuario->delete();

            return response()->json(['message' => 'Usuário deletado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocorreu um erro ao deletar o usuário',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
