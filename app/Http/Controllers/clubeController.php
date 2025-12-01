<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Clube;
use App\Models\Esporte;
use App\Models\Funcao;
use App\Models\Posicao;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ClubeController extends Controller
{
    public function showProfilePage(Request $request, $id)
    {
        $clube = Clube::with([
            'esporte', 
            'categoria', 
            'esportesExtras', 
            'oportunidades.esporte',
            'oportunidades.inscricoes',
            'oportunidades.candidatos',
        ])->findOrFail($id);

        $membroClubeController = new MembroClubeController();

        $membrosAgrupados = $membroClubeController->getMembrosAgrupados((string) $clube->id);

        $esportes = Esporte::with('posicoes')->get();

        $funcoes = Funcao::all();

        $posicoes = Posicao::all();

        $esportes   = Esporte::all();
        $categorias = Categoria::all();

        return view('clube.perfil', [
            'clube'      => $clube,
            'esportes'   => $esportes,
            'categorias' => $categorias,
        ]);
    }

    public function showWebPage()
    {
        $clubes     = Clube::with('esporte', 'categoria')->get();
        $esportes   = Esporte::all();
        $categorias = Categoria::all();

        return view('admin.listas.clubes')->with([
            'clubes'     => $clubes,
            'esportes'   => $esportes,
            'categorias' => $categorias,
        ]);
    }

    public function index()
    {
        $clubes = Clube::all();
        return response()->json($clubes);
    }

    public function store(Request $request)
    {
         Log::info('DADOS RECEBIDOS NO CADASTRO CLUBE', $request->all());

        try {
            $validatedData = $request->validate([
                'nomeClube'       => 'required|string|max:255|unique:clubes,nomeClube',
                'cnpjClube'       => 'required|string|max:20|unique:clubes,cnpjClube',
                'emailClube'      => 'required|email|string|max:255|unique:clubes,emailClube',
                'cidadeClube'     => 'required|string|max:255',
                'estadoClube'     => 'required|string|max:255',
                'anoCriacaoClube' => 'required|date',
                'enderecoClube'   => 'required|string|max:255',
                'bioClube'        => 'nullable|string',
                'senhaClube'      => 'required|string|min:6',
                'categoria_id'    => 'required|exists:categorias,id',
                'esporte_id'      => 'required|exists:esportes,id',
                'fotoPerfilClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
                'fotoBannerClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
            ]);

            $caminhoFotoPerfil = null;
            $caminhoFotoBanner = null;

            if ($request->hasFile('fotoPerfilClube')) {
                $caminhoFotoPerfil = $request->file('fotoPerfilClube')->store('clubes/perfis', 'public');
            }

            if ($request->hasFile('fotoBannerClube')) {
                $caminhoFotoBanner = $request->file('fotoBannerClube')->store('clubes/banners', 'public');
            }

            $clube = Clube::create([
                'nomeClube'       => $validatedData['nomeClube'],
                'cnpjClube'       => $validatedData['cnpjClube'],
                'emailClube'      => $validatedData['emailClube'],
                'cidadeClube'     => $validatedData['cidadeClube'],
                'estadoClube'     => $validatedData['estadoClube'],
                'anoCriacaoClube' => $validatedData['anoCriacaoClube'],
                'enderecoClube'   => $validatedData['enderecoClube'],
                'status'          => Clube::STATUS_PENDENTE,
                'bioClube'        => $validatedData['bioClube'] ?? null,
                'senhaClube'      => Hash::make($validatedData['senhaClube']),
                'fotoPerfilClube' => $caminhoFotoPerfil,
                'fotoBannerClube' => $caminhoFotoBanner,
                'categoria_id'    => $validatedData['categoria_id'],
                'esporte_id'      => $validatedData['esporte_id'],
            ]);

            $clube->esportes()->syncWithoutDetaching([$validatedData['esporte_id']]);

            return response()->json([
                'message' => 'Clube cadastrado com sucesso e enviado para análise do administrador.',
            ], 201);

        } catch (ValidationException $e) {
                return response()->json([
                    'message' => 'Erro de validação.',
                    'errors'  => $e->errors(),
                ], 422);
            } catch (\Throwable $e) {
                Log::error('Erro ao cadastrar clube', [
                    'exception' => $e,
                ]);

                return response()->json([
                    'message' => 'Erro interno ao cadastrar o clube.',
                ], 500);
            }
    }

    public function storeByAdmin(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nomeClube'       => 'required|string|max:255|unique:clubes,nomeClube',
                'cnpjClube'       => 'required|string|max:20|unique:clubes,cnpjClube',
                'emailClube'      => 'required|email|string|max:255|unique:clubes,emailClube',
                'cidadeClube'     => 'required|string|max:255',
                'estadoClube'     => 'required|string|max:255',
                'anoCriacaoClube' => 'required|date',
                'enderecoClube'   => 'required|string|max:255',
                'bioClube'        => 'nullable|string',
                'categoria_id'    => 'required|exists:categorias,id',
                'esporte_id'      => 'required|exists:esportes,id',
                'fotoPerfilClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
                'fotoBannerClube' => 'nullable|image|mimes:jpg,png,jpeg,webp,gif,svg|max:2048',
            ]);

            $senhaTemporariaAleatoria = Str::random(16);

            $clube = Clube::create([
                'nomeClube'       => $validatedData['nomeClube'],
                'cnpjClube'       => $validatedData['cnpjClube'],
                'emailClube'      => $validatedData['emailClube'],
                'cidadeClube'     => $validatedData['cidadeClube'],
                'estadoClube'     => $validatedData['estadoClube'],
                'anoCriacaoClube' => $validatedData['anoCriacaoClube'],
                'status'          => Clube::STATUS_ATIVO,
                'enderecoClube'   => $validatedData['enderecoClube'],
                'bioClube'        => $validatedData['bioClube'] ?? null,
                'senhaClube'      => Hash::make($senhaTemporariaAleatoria),
                'categoria_id'    => $validatedData['categoria_id'],
                'esporte_id'      => $validatedData['esporte_id'],
            ]);

            $clube->esportes()->syncWithoutDetaching([$validatedData['esporte_id']]);

            return response()->json(
                $clube->load('categoria', 'esporte', 'esportes'),
                201
            );

        } catch (ValidationException $e) {
        return response()->json([
            'message' => 'Erro de validação.',
            'errors'  => $e->errors(),
        ], 422);
    } catch (\Throwable $e) {
        Log::error('Erro ao cadastrar clube', [
            'exception' => $e,
        ]);

        return response()->json([
            'message' => 'Erro interno ao cadastrar o clube.',
        ], 500);
    }
    }

    public function show($id)
    {
        try {
            $clube = Clube::findOrFail($id);

            $utilizadorAutenticado = Auth::user();
            $podeVer = true;

            if (!$podeVer) {
                Log::warning('Acesso negado ao clube show', [
                    'autenticado_id'      => $utilizadorAutenticado ? $utilizadorAutenticado->id : null,
                    'autenticado_tipo'    => $utilizadorAutenticado ? get_class($utilizadorAutenticado) : 'Nenhum utilizador autenticado',
                    'clube_solicitado_id' => $clube->id,
                ]);

                return response()->json(['message' => 'Acesso não autorizado'], 403);
            }

            return response()->json(
                $clube->load('categoria', 'esporte', 'esportes'),
                200
            );

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $clube = Clube::findOrFail($id);

            $validatedData = $request->validate([
                'nomeClube'       => 'sometimes|string|max:255',
                'cnpjClube'       => ['sometimes', 'string', 'max:20', Rule::unique('clubes', 'cnpjClube')->ignore($clube->id)],
                'emailClube'      => ['sometimes', 'string', 'max:255', Rule::unique('clubes', 'emailClube')->ignore($clube->id)],
                'cidadeClube'     => 'sometimes|string|max:255',
                'estadoClube'     => 'sometimes|string|max:255',
                'anoCriacaoClube' => 'sometimes|date',
                'enderecoClube'   => 'sometimes|string|max:255',
                'bioClube'        => 'nullable|string',
                'senhaClube'      => 'sometimes|string|min:6|confirmed',
                'categoria_id'    => 'sometimes|exists:categorias,id',
                'esporte_id'      => 'sometimes|exists:esportes,id',
                'esportes_ids'    => 'sometimes|array',
                'esportes_ids.*'  => 'exists:esportes,id',
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

            if ($clube->status !== Clube::STATUS_PENDENTE) {
                $clube->status           = Clube::STATUS_PENDENTE;
                $clube->reviewed_by      = null;
                $clube->reviewed_at      = null;
                $clube->bloque_reason    = null;
                $clube->rejection_reason = null;
            }

            $clube->save();

            if (array_key_exists('esportes_ids', $validatedData)) {
                $ids = $validatedData['esportes_ids'] ?? [];

                $principalId = $clube->esporte_id;
                if (array_key_exists('esporte_id', $validatedData)) {
                    $principalId = $validatedData['esporte_id'];
                }

                if ($principalId && !in_array($principalId, $ids)) {
                    $ids[] = $principalId;
                }

                $clube->esportes()->sync($ids);
            } else {
                if (array_key_exists('esporte_id', $validatedData)) {
                    $clube->esportes()->syncWithoutDetaching([$validatedData['esporte_id']]);
                }
            }

            return response()->json(
                $clube->fresh()->load('categoria', 'esporte', 'esportes'),
                200
            );

        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Ocorreu um erro ao atualizar o clube',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

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
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

        protected function getAuthenticatedClube(): ?Clube
    {
        return Auth::guard('club_sanctum')->user() ?? auth('club')->user();
    }

    public function updateEmail(Request $request)
{
    /** @var \App\Models\Clube|null $clube */
    $clube = Auth::guard('club_sanctum')->user();

    if (! $clube instanceof Clube) {
        return response()->json([
            'message' => 'Clube não autenticado.',
        ], 401);
    }

    $validated = $request->validate([
        'new_email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('clubes', 'emailClube')->ignore($clube->id),
        ],
    ]);

    $clube->emailClube = $validated['new_email'];
    $clube->save();

    return response()->json([
        'message' => 'E-mail atualizado com sucesso.',
    ]);
}

public function updateCnpj(Request $request)
{
    /** @var \App\Models\Clube|null $clube */
    $clube = Auth::guard('club_sanctum')->user();

    if (! $clube instanceof Clube) {
        return response()->json([
            'message' => 'Clube não autenticado.',
        ], 401);
    }

    $validated = $request->validate([
        'new_cnpj' => [
            'required',
            'string',
            'max:20',
            Rule::unique('clubes', 'cnpjClube')->ignore($clube->id),
        ],
    ]);

    $clube->cnpjClube = $validated['new_cnpj'];
    $clube->save();

    return response()->json([
        'message' => 'CNPJ atualizado com sucesso.',
    ]);
}

        public function updatePassword(Request $request)
    {
        $clube = $this->getAuthenticatedClube();

        if (! $clube) {
            return response()->json(['message' => 'Clube não autenticado.'], 401);
        }

        $data = $request->validate([
            'current_password'      => 'required|string',
            'password'              => 'required|string|min:6|confirmed',
            // precisa enviar também "password_confirmation"
        ]);

        if (! Hash::check($data['current_password'], $clube->senhaClube)) {
            return response()->json([
                'message' => 'A senha atual informada está incorreta.',
            ], 422);
        }

        $clube->senhaClube = Hash::make($data['password']);
        $clube->save();

        return response()->json([
            'message' => 'Senha atualizada com sucesso.',
        ]);
    }

        public function destroyMe(Request $request)
    {
        $clube = $this->getAuthenticatedClube();

        if (! $clube) {
            return response()->json(['message' => 'Clube não autenticado.'], 401);
        }

        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'error'   => 'Erro ao excluir conta.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }




}
