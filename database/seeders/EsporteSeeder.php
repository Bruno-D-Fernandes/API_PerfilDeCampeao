<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Esporte;

class EsporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $esportes = [
            ['id' => 1, 'nomeEsporte' => 'Futebol','descricaoEsporte' =>'jogo com bola'], // Colocar depois desc Esporte --ass: Bruno
            ['id' => 2, 'nomeEsporte' => 'Basquete','descricaoEsporte' =>'jogo de colocar a bola'],
            ['id' => 3, 'nomeEsporte' => 'Vôlei','descricaoEsporte' =>'bater a bola na mão'],
            ['id' => 4, 'nomeEsporte' => 'Tênis','descricaoEsporte' =>'bater na bola com o taco'],
            ['id' => 5, 'nomeEsporte' => 'Rugby','descricaoEsporte' =>'jogo com bola oval'],
            ['id' => 6, 'nomeEsporte' => 'Críquete','descricaoEsporte' =>'jogo com bastão e bola'],
            ['id' => 7, 'nomeEsporte' => 'Hóquei','descricaoEsporte' =>'jogo com stick e bola'],
            ['id' => 8, 'nomeEsporte' => 'Badminton','descricaoEsporte' =>'jogo com raquete e peteca'],
            ['id' => 9, 'nomeEsporte' => 'Futebol Americano','descricaoEsporte' =>'jogo com bola oval e touchdowns'],
            ['id' => 10, 'nomeEsporte' => 'Handebol','descricaoEsporte' =>'jogo com bola e gol'],
            ['id' => 11, 'nomeEsporte' => 'Futsal','descricaoEsporte' =>'versão de salão do futebol'],
        ];

        foreach ($esportes as $esporte) {
            Esporte::updateOrCreate(
                ['id' => $esporte['id']],
                ['nomeEsporte' => $esporte['nomeEsporte']]
            );
        }
    }
}
