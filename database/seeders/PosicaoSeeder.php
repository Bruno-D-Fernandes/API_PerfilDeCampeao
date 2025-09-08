<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Posicao;

class PosicaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posicoesPorEsporte = [
            1 => [ // Futebol
                'Atacante',
                'Zagueiro',
                'Goleiro',
                'Meio-campo',
            ],
            2 => [ // Basquete
                'Armador',
                'Ala-armador',
                'Ala',
                'Ala-pivô',
                'Pivô',
            ],
            3 => [ // Vôlei
                'Levantador',
                'Ponteiro',
                'Oposto',
                'Central',
                'Líbero',
            ],
            4 => [ // Tênis
                'Simples',
                'Duplas',
            ],
        ];

        $id = 1; // Para controle manual de ID

        foreach ($posicoesPorEsporte as $idEsporte => $posicoes) {
            foreach ($posicoes as $nomePosicao) {
                Posicao::firstOrCreate(
                    ['id' => $id],
                    [
                        'nomePosicao' => $nomePosicao,
                        'idEsporte' => $idEsporte,
                    ]
                );
                $id++;
            }
        }
    }
}
