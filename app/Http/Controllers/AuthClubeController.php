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
        
        $request->session()->invalidate();

        Auth::guard('club')->login($clube);
        
        $request->session()->regenerate();
        $request->session()->save();

        $token = $clube->createToken('web_dashboard_token', ['club'])->plainTextToken;
        session(['clube_api_token' => $token]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Login realizado com sucesso!',
                'access_token' => "Bearer $token",
                'clube' => $clube,
                'redirect_url' => route('clube.dashboard') 
            ], 200);
        } 

        return redirect()->intended(route('clube.dashboard'));
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('club')->user();
        if ($user) {
            $user->tokens()->where('name', 'web_dashboard_token')->delete();
        }
        
        Auth::guard('club')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
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
}