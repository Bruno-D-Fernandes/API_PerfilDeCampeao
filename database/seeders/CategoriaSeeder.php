<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['id' => 1, 'nomeCategoria' => 'Amador', 'descricaoCategoria' => 'Categoria amadora'],
            ['id' => 2, 'nomeCategoria' => 'Profissional', 'descricaoCategoria' => 'Categoria profissional'],
            ['id' => 3, 'nomeCategoria' => 'Semi-profissional', 'descricaoCategoria' => 'Categoria semi-profissional'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate(['id' => $categoria['id']], $categoria);
        }
    }
}
