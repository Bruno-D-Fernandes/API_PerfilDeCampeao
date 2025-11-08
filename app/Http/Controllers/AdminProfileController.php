<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function updateIdentidade(Request $request)
    {
        $admin = $request->user();

        $request->validate([
            'nome' => 'sometimes|string|max:255',
            'foto_perfil' => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->has('nome')) {
            $admin->nome = $request->nome;
        }

        if ($request->hasFile('foto_perfil')) {
            $caminhoAntigo = $admin->getRawOriginal('foto_perfil');

            if ($caminhoAntigo) {
                Storage::disk('public')->delete($caminhoAntigo);
            }

            $admin->foto_perfil = $request->file('foto_perfil')->store('admins/perfis', 'public');
        }

        $admin->save();

        return response()->json($admin);
    }

    public function updateInformacoes(Request $request)
    {
        $admin = $request->user();

        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('tbadm')->ignore($admin->id),
            ],
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'data_nascimento' => 'nullable|date',
        ]);

        $admin->email = $request->email;

        if ($request->has('telefone')) {
            $admin->telefone = $request->telefone;
        }

        if ($request->has('endereco')) {
            $admin->endereco = $request->endereco;
        }

        if ($request->has('data_nascimento')) {
            $admin->data_nascimento = $request->data_nascimento;
        }

        $admin->save();

        return response()->json($admin, 200);
    }
}