<?php

namespace App\Http\Controllers;

use App\Models\Funcao;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FuncaoController extends Controller
{
    public function showWebPage()
    {
        $funcoes = Funcao::all();

        return view('admin.listas.funcoes')->with(['funcoes' => $funcoes]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 15);
            $funcoes = Funcao::latest()->paginate($perPage);

            return response()->json($funcoes);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar funções', 'message' => $e->getMessage()], 500);
        }
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
        $data = $request->validate([
            'nome' => 'required|string|max:100|unique:funcoes',
            'descricao'   => 'required|string|max:255',
        ]);

        $funcao = Funcao::create($data);

        return response()->json($funcao, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $funcao = Funcao::findOrFail($id);

        return response()->json($funcao, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $funcao = Funcao::findOrFail($id);

        $data = $request->validate([
            'nome' => ['sometimes', 'string', 'max:100', Rule::unique('funcoes', 'nome')->ignore($funcao->id)],
            'descricao'   => 'sometimes|string|max:255',
        ]);

        $funcao->update($data);

        return response()->json($funcao);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $funcao = Funcao::findOrFail($id);
        $funcao->delete();
        return response()->json(['sucesso' => true]);
    }
}
