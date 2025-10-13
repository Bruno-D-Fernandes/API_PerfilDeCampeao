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
            ['id' => 1, 'oportunidade_id' => 1, 'usuario_id' => 1, 'status' => 'nsei oque é isso', 'created_at' => '2025-10-11 18:19:03' ],
            ['id' => 2, 'oportunidade_id' => 2, 'usuario_id' => 2, 'status' => 'nsei oque éé isso', 'created_at' => '2025-10-11 18:19:03' ],
        ];

foreach ($inscricao as $data) {
            inscricao::create($data);
        }
    }
}
