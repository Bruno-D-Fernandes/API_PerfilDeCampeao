<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caracteristica;

class CaracteristicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $caracteristicas = [
            // Basquete id = 2
            ['caracteristica' => 'Envergadura', 'unidade_medida' => 'cm', 'esporte_id' => 2],
            ['caracteristica' => 'Altura do Salto', 'unidade_medida' => 'cm', 'esporte_id' => 2],
        ];

        foreach ($caracteristicas as $data) {
            Caracteristica::firstOrCreate(
                [
                    'caracteristica' => $data['caracteristica'],
                    'esporte_id' => $data['esporte_id'],
                ],
                [
                    'unidade_medida' => $data['unidade_medida'],
                ]
            );
        }
    }
}
