<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\inscricao;
use App\Models\oportunidades;
use App\Models\usuarios;
class InscricaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inscricao = [
            ['id' => 1, 'oportunidade_id' => 1, 'usuario_id' => 1, 'status' => 'approved'],
        ];

foreach ($inscricao as $data) {
            inscricao::create($data);
        }
    }
}
