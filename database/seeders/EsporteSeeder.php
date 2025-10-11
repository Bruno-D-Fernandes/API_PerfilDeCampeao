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
        ];

        foreach ($esportes as $esporte) {
            Esporte::updateOrCreate(
                ['id' => $esporte['id']],
                ['nomeEsporte' => $esporte['nomeEsporte']]
            );
        }
    }
}
