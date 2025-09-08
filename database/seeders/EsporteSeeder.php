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
            ['id' => 1, 'nome' => 'Futebol'],
            ['id' => 2, 'nome' => 'Basquete'],
            ['id' => 3, 'nome' => 'Vôlei'],
            ['id' => 4, 'nome' => 'Tênis'],
        ];

        foreach ($esportes as $esporte) {
            Esporte::updateOrCreate(
                ['id' => $esporte['id']],
                ['nome' => $esporte['nome']]
            );
        }
    }
}
