<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Clube;
use App\Models\Esporte;
use App\Models\Categoria;

class AuthAdmController extends Controller
{
    
public function showLoginForm()
    {

        return view('auth.admin.login');
    }

    public function loginAdm(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $admin = \App\Models\Admin::where('email', $request->email)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            $msg = 'Credenciais inválidas.';
            return $request->wantsJson() 
                ? response()->json(['message' => $msg], 401) 
                : back()->withErrors(['email' => $msg])->withInput();
        }
        
        $request->session()->invalidate();

        Auth::guard('admin')->login($admin);
        
        $request->session()->regenerate();
        $request->session()->save();

        $token = $admin->createToken('admin_dashboard_token', ['admin'])->plainTextToken;
        session(['admin_api_token' => $token]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Login de Admin realizado!',
                'access_token' => "Bearer $token",
                'admin' => $admin,
                'redirect_url' => route('admin.dashboard') 
            ], 200);
        } 

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logoutAdm(Request $request)
    {
        $user = Auth::guard('admin')->user();

        if ($user) {
            $user->tokens()->where('name', 'admin_dashboard_token')->delete();
        }
        
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}