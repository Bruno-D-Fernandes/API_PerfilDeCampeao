<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clube;
use Illuminate\Support\Facades\Hash;

class ClubeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Clube::firstOrCreate([
            'nomeClube' => 'Vasco'
        ], [
            'cidadeClube' => 'São Paulo',
            'estadoClube' => 'SP',
            'anoCriacaoClube' => '2000-01-01',
            'cnpjClube' => '00.000.000/0000-00',
            'enderecoClube' => 'Rua Exemplo, 123',
            'bioClube' => 'O maior clube do mundo, criado por seeder!',
            'senhaClube' => Hash::make('senha123'),
        ]);
    }
}
