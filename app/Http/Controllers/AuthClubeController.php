<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Clube;
use App\Models\Esporte;
use App\Models\Categoria;

class AuthClubeController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('club')->check()) {
            return redirect()->route('clube.dashboard');
        }
        return view('auth.clube.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'cnpjClube'  => ['required'],
            'senhaClube' => ['required'],
        ]);

        $clube = Clube::where('cnpjClube', $request->cnpjClube)->first();

        if (! $clube || ! Hash::check($request->senhaClube, $clube->senhaClube)) {
            $msg = 'Credenciais inválidas.';
            return $request->wantsJson() 
                ? response()->json(['message' => $msg], 401) 
                : back()->withErrors(['cnpjClube' => $msg])->withInput();
        }
        
        if ($clube->status !== Clube::STATUS_ATIVO) {
            $msg = 'Conta inativa ou bloqueada.';
            return $request->wantsJson() 
                ? response()->json(['message' => $msg], 403) 
                : back()->withErrors(['cnpjClube' => $msg])->withInput();
        }

        Auth::guard('club')->login($clube);

        $token = $clube->createToken('web_dashboard_token', ['club'])->plainTextToken;

        if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Login realizado com sucesso!',
                'access_token' => "Bearer $token",
                'clube' => $clube,
                'redirect_url' => route('clube.dashboard') 
            ], 200);
        }

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerate();
            $request->session()->put('clube_api_token', $token);
            return redirect()->intended(route('clube.dashboard'));
        }

        return redirect()->to(route('clube.dashboard'));
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('club')->user();
        if ($user) {
            $user->tokens()->where('name', 'web_dashboard_token')->delete();
        }
        
        Auth::guard('club')->logout();
        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Logout realizado com sucesso.'], 200);
        }

        return redirect()->route('clube.login');
    }

    public function showRegisterForm()
    {
        if (Auth::guard('club')->check()) {
            return redirect()->route('clube.dashboard');
        }
        return view('auth.clube.register')->with(['esportes' => Esporte::all(), 'categorias' => Categoria::all()]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'cnpjClube'                 => ['required', 'string', 'unique:clubes,cnpjClube'],
            'emailClube'                => ['nullable', 'email', 'unique:clubes,emailClube'],
            'senhaClube'                => ['required', 'string', 'min:6', 'confirmed'],
            'nomeClube'                 => ['required', 'string', 'max:255'],
            'esporte_id'                => ['required', 'exists:esportes,id'],
            'categoria_id'              => ['required', 'exists:categorias,id'],
            'bioClube'                  => ['nullable', 'string', 'max:1000'],
            'anoCriacaoClube'           => ['nullable', 'date'],
            'cidadeClube'               => ['required', 'string', 'max:100'],
            'estadoClube'               => ['required', 'string', 'max:50'],
            'enderecoClube'             => ['required', 'string', 'max:255'],
            'termos'                    => ['accepted'],
        ]);

        $clube = Clube::create([
            'cnpjClube'   => $request->cnpjClube,
            'emailClube'  => $request->emailClube,
            'senhaClube'  => Hash::make($request->senhaClube),
            'nomeClube'   => $request->nomeClube,
            'esporte_id'  => $request->esporte_id,
            'categoria_id'=> $request->categoria_id,
            'bioClube'    => $request->bioClube,
            'anoCriacaoClube' => $request->anoCriacaoClube,
            'cidadeClube' => $request->cidadeClube,
            'estadoClube' => $request->estadoClube,
            'enderecoClube'=> $request->enderecoClube,
            'status'      => Clube::STATUS_PENDENTE,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Cadastro realizado com sucesso! Um administrador verificará suas informações antes de liberar o acesso.',
                'clube'   => $clube,
            ], 201);
        }

        return redirect()->route('clube.login')
            ->with('success', 'Cadastro realizado com sucesso! Um administrador verificará suas informações antes de liberar o acesso.');
    }

    public function updateAccount(Request $request)
    {
        try {
            $request->validate([
                'nomeClube'       => 'required|string|max:255',
                'cepClube'        => 'nullable|string',
                'enderecoClube'   => 'required|string',
                'cidadeClube'     => 'required|string',
                'estadoClube'     => 'required|string|max:2',
                'anoCriacaoClube' => 'required|date',
                'bioClube'        => 'nullable|string',
                'categoria_id'    => 'required',
                'esporte_id'      => 'required',
                'esportes_extras' => 'nullable|array',
                'fotoPerfilClube' => 'nullable|image|max:2048',
                'fotoBannerClube' => 'nullable|image|max:2048',
            ]);

            $clube = Auth::guard('club')->user()->load('oportunidades');

            if ($request->hasFile('fotoPerfilClube')) {
                $path = $request->file('fotoPerfilClube')->store('clubes/perfis', 'public');
                $clube->fotoPerfilClube = $path;
            }

            if ($request->hasFile('fotoBannerClube')) {
                $path = $request->file('fotoBannerClube')->store('clubes/banners', 'public');
                $clube->fotoBannerClube = $path;
            }

            $dados = $request->except(['fotoPerfilClube', 'fotoBannerClube', 'esportes_extras', '_token', '_method']);

            $clube->update($dados);

            if ($request->has('esportes_extras')) {
                $clube->esportesExtras()->sync($request->esportes_extras);
            } else {
                $clube->esportesExtras()->detach();
            }

            $clube->refresh();

            $html = view('clube.partials.profile-page', [
                'clube' => $clube,
                'oportunidades' => $clube->oportunidades,
                'categorias' => Categoria::all(),
            ])->render();

            return response()->json([
                'success' => true, 
                'message' => 'Perfil atualizado com sucesso!',
                'data' => [
                    'clube' => $clube,
                    'html' => $html,
                    'hasIncompleteProfile' => $clube->hasIncompleteProfile()
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Erro interno: ' . $e->getMessage()
            ], 500);
        }
    }
}