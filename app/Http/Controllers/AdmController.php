<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdmController extends Controller
{
     public function loginAdm(Request $request)
    {
        try {
            $user = Admin::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Credenciais inválidas'], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
