<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use App\Models\Clube;
use Carbon\Carbon;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $clube = Clube::first();

        if (!$clube) {
            echo "Nenhum clube encontrado. Crie um clube antes de rodar este seeder.\n";
            return;
        }

        Evento::create([
            'clube_id' => $clube->id,
            'titulo' => 'Torneio da Zona Leste',
            'descricao' => 'Competição oficial organizada pelo clube.',
            'data_hora_inicio' => Carbon::now()->addDays(3),
            'data_hora_fim' => Carbon::now()->addDays(3)->addHours(4),

            'cep' => '03545-200',
            'estado' => 'SP',
            'cidade' => 'São Paulo',
            'bairro' => 'Guaianases',
            'rua' => 'Rua do Clube',
            'numero' => '120',
            'complemento' => 'Quadra 2',

            'limite_participantes' => 30,
        ]);

        Evento::create([
            'clube_id' => $clube->id,
            'titulo' => 'Avaliação de Atletas 2025',
            'descricao' => 'Avaliação de novos talentos para a temporada 2025.',
            'data_hora_inicio' => Carbon::now()->addDays(8),
            'data_hora_fim' => Carbon::now()->addDays(8)->addHours(6),

            'cep' => '03012-010',
            'estado' => 'SP',
            'cidade' => 'São Paulo',
            'bairro' => 'Brás',
            'rua' => 'Avenida Principal',
            'numero' => '500',
            'complemento' => null,

            'limite_participantes' => 50,
        ]);
    }
}
