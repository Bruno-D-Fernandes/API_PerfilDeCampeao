<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clube;
use Illuminate\Support\Facades\Validator;

class clubeController extends Controller
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
        $validator = Validator::make($request->all(), [
            'nomeClube' => 'required|string|max:255',
            'cidadeClube' => 'required|string|max:255',
            'estadoClube' => 'required|string|max:255',
            'anoCriacaoClube' => 'required|date',
            'cnpjClube' => 'required|string|max:20|unique:clubes',
            'enderecoClube' => 'required|string|max:255',
            'bioClube' => 'nullable|string',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $clube = Clube::create($request->all());
        return response()->json($clube, 201);
    }

    // Mostrar um clube específico
    public function show($id)
    {
        $clube = Clube::find($id);
        if(!$clube){
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }
        return response()->json($clube);
    }

    // Atualizar um clube
    public function update(Request $request, $id)
    {
        $clube = Clube::find($id);
        if(!$clube){
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $clube->update($request->all());
        return response()->json($clube);
    }

    // Deletar um clube
    public function destroy($id)
    {
        $clube = Clube::find($id);
        if(!$clube){
            return response()->json(['message' => 'Clube não encontrado'], 404);
        }

        $clube->delete();
        return response()->json(['message' => 'Clube deletado com sucesso']);
    }
}
