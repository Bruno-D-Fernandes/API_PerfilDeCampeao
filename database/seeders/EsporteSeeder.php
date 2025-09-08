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
            ['id' => 1, 'nomeEsporte' => 'Futebol'], // Colocar depois desc Esporte --ass: Bruno
            ['id' => 2, 'nomeEsporte' => 'Basquete'],
            ['id' => 3, 'nomeEsporte' => 'Vôlei'],
            ['id' => 4, 'nomeEsporte' => 'Tênis'],
        ];

        foreach ($esportes as $esporte) {
            Esporte::updateOrCreate(
                ['id' => $esporte['id']],
                ['nomeEsporte' => $esporte['nomeEsporte']]
            );
        }
    }
}
