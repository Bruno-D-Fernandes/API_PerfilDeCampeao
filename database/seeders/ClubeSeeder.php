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
            'nomeClube' => 'Clube Exemplo'
        ], [
            'nomeClube' => 'Club de Regatas Vasco da Gama',
            'cnpjClube' => '00.000.000/0001-91',
            'emailClube' => 'contato@vasco.com.br',
            'cidadeClube' => 'Rio de Janeiro',
            'estadoClube' => 'RJ',
            'anoCriacaoClube' => '1898-08-21',
            'enderecoClube' => 'São Januário, Rua General Almério de Moura 131',
            'bioClube' => 'Clube de futebol tradicional do Rio de Janeiro. Fundado em 1898, com foco em esporte e formação.',
            'senhaClube' => Hash::make('vasco123'),
            'categoria_id' => 2,
            'esporte_id' => 1,
        ]);
    }
}
