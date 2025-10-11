<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clube;
use Illuminate\Support\Facades\Hash;

class ClubeSeeder extends Seeder
{
    public function run(): void
    {
        $clubes = [
            // Clube 1: Administrador
            [
                'nomeClube'         => 'Administrador',
                'emailClube'        => 'admin@example.com',
                'senhaClube'        => Hash::make('password'), // <-- senha hash
                'cidadeClube'       => 'Sede',
                'estadoClube'       => 'SP',
                'anoCriacaoClube'   => '2020-01-01',
                'cnpjClube'         => '00.000.000/0001-00',
                'enderecoClube'     => 'Rua Principal, 123',
                'bioClube'          => 'Conta de administrador geral do sistema.',
                'idEsporte'         => 2,
                'categoria_id'       => 1, // <-- CAMPO ADICIONADO
            ],
            // Clube 2: Futebol
            [
                'nomeClube'         => 'Academia da Bola FC',
                'emailClube'        => 'futebol@example.com',
                                'senhaClube'        => Hash::make('password'), // <-- senha hash
                'cidadeClube'       => 'Rio de Janeiro',
                'estadoClube'       => 'RJ',
                'anoCriacaoClube'   => '1995-05-10',
                'cnpjClube'         => '11.111.111/0001-11',
                'enderecoClube'     => 'Avenida das Américas, 500',
                'bioClube'          => 'Clube de formação de atletas de futebol no Rio de Janeiro.',
                'idEsporte'         => 1,
                'categoria_id'       =>  1, // <-- CAMPO ADICIONADO
            ],
            // Clube 3: Basquete
            [
                'nomeClube'         => 'Cestas de Ouro',
                'emailClube'        => 'basquete@example.com',
                'senhaClube'        => Hash::make('password'), // <-- senha hash
                'cidadeClube'       => 'São Paulo',
                'estadoClube'       => 'SP',
                'anoCriacaoClube'   => '2002-11-23',
                'cnpjClube'         => '22.222.222/0001-22',
                'enderecoClube'     => 'Rua Augusta, 900',
                'bioClube'          => 'Promovendo o basquete de base na capital paulista.',
                'idEsporte'         =>  4,
                'categoria_id'    =>  2, // <-- CAMPO ADICIONADO
            ],
        ];

        foreach ($clubes as $clubeData) {
    $clubeData['senhaClube'] = Hash::make('password'); // força re-hash aqui
    Clube::updateOrCreate(
        ['emailClube' => $clubeData['emailClube']],
        $clubeData
    );
}

        $this->command->info(count($clubes) . ' clubes foram criados ou atualizados com sucesso!');
    }
}
