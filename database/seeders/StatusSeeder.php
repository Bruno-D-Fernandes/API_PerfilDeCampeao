<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Continue daqui */

        Status::create([
            'nome' => 'Ativo',
            'corFundo' => '#E9F9EF',
            'corTexto' => '#23C552',
            'descricao' => 'A conta do usuário permanece ativa!'
        ]);
    }
}
