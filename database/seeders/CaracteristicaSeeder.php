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
            // Futebol id = 1
            ['caracteristica' => 'Altura', 'unidade_medida' => 'cm', 'esporte_id' => 1],
            ['caracteristica' => 'Peso', 'unidade_medida' => 'kg', 'esporte_id' => 1],
            ['caracteristica' => 'Perna dominante', 'unidade_medida' => 'string', 'esporte_id' => 1],

            // Basquete id = 2
            ['caracteristica' => 'Altura', 'unidade_medida' => 'cm', 'esporte_id' => 2],
            ['caracteristica' => 'Envergadura', 'unidade_medida' => 'cm', 'esporte_id' => 2],
            ['caracteristica' => 'Mão dominante', 'unidade_medida' => 'string', 'esporte_id' => 2],
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
