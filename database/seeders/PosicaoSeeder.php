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
                'Goleiro',
                'Zagueiro',
                'Lateral-direito',
                'Lateral-esquerdo',
                'Volante',
                'Meio-campo',
                'Meia-atacante',
                'Ponta-direita',
                'Ponta-esquerda',
                'Centroavante',
                'Atacante',
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
            5 => [ // Rugby
                'Pilar Esquerdo',
                'Pilar Direito',
                'Hooker',
                'Segunda Linha',
                'Asa Esquerda',
                'Asa Direita',
                'Oitavo',
                'Scrum-half',
                'Abertura',
                'Centro',
                'Ponta',
                'Fullback',
            ],
            6 => [ // Críquete
                'Batedor',
                'Lançador (Bowler)',
                'Wicket-keeper',
                'All-rounder',
                'Defensor Interno',
                'Defensor Externo',
            ],
            7 => [ // Hóquei
                'Goleiro',
                'Defensor',
                'Lateral',
                'Meio-campista',
                'Atacante',
                'Ponta-direita',
                'Ponta-esquerda',
            ],
            8 => [ // Badminton
                'Simples Masculino',
                'Simples Feminino',
                'Duplas Masculinas',
                'Duplas Femininas',
                'Duplas Mistas',
            ],
            9 => [ // Futebol Americano
                'Quarterback',
                'Running Back',
                'Wide Receiver',
                'Tight End',
                'Offensive Lineman',
                'Defensive Lineman',
                'Linebacker',
                'Cornerback',
                'Safety',
                'Kicker',
                'Punter',
            ],
            10 => [ // Handebol
                'Goleiro',
                'Armador Central',
                'Armador Esquerdo',
                'Armador Direito',
                'Ponta Esquerda',
                'Ponta Direita',
                'Pivô',
            ],
            11 => [ // Futsal
                'Goleiro',
                'Fixo',
                'Ala Direita',
                'Ala Esquerda',
                'Pivô',
            ],
        ];

        foreach ($posicoesPorEsporte as $idEsporte => $posicoes) {
            foreach ($posicoes as $nomePosicao) {
                Posicao::firstOrCreate([
                    'nomePosicao' => $nomePosicao,
                    'idEsporte'   => $idEsporte,
                ]);
            }
        }
    }
}
