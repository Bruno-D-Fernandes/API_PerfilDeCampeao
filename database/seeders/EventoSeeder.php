<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use App\Models\Clube;
use Illuminate\Support\Carbon;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clubesIds = Clube::pluck('id')->all();

        // Se não tiver clubes, não faz sentido criar eventos
        if (empty($clubesIds)) {
            return;
        }

        $locais = [
            [
                'cep'     => '01001-000',
                'estado'  => 'SP',
                'cidade'  => 'São Paulo',
                'bairro'  => 'Centro',
                'rua'     => 'Rua das Flores',
            ],
            [
                'cep'     => '20040-002',
                'estado'  => 'RJ',
                'cidade'  => 'Rio de Janeiro',
                'bairro'  => 'Copacabana',
                'rua'     => 'Avenida Atlântica',
            ],
            [
                'cep'     => '30130-000',
                'estado'  => 'MG',
                'cidade'  => 'Belo Horizonte',
                'bairro'  => 'Savassi',
                'rua'     => 'Rua Pernambuco',
            ],
            [
                'cep'     => '80010-000',
                'estado'  => 'PR',
                'cidade'  => 'Curitiba',
                'bairro'  => 'Centro',
                'rua'     => 'Avenida Sete de Setembro',
            ],
            [
                'cep'     => '40020-000',
                'estado'  => 'BA',
                'cidade'  => 'Salvador',
                'bairro'  => 'Barra',
                'rua'     => 'Avenida Oceânica',
            ],
            [
                'cep'     => '50010-000',
                'estado'  => 'PE',
                'cidade'  => 'Recife',
                'bairro'  => 'Boa Vista',
                'rua'     => 'Rua da Aurora',
            ],
            [
                'cep'     => '90010-000',
                'estado'  => 'RS',
                'cidade'  => 'Porto Alegre',
                'bairro'  => 'Moinhos de Vento',
                'rua'     => 'Rua Padre Chagas',
            ],
            [
                'cep'     => '60110-000',
                'estado'  => 'CE',
                'cidade'  => 'Fortaleza',
                'bairro'  => 'Meireles',
                'rua'     => 'Avenida Beira Mar',
            ],
        ];

        $titulos = [
            'Treino Técnico',
            'Avaliação de Atletas',
            'Jogo Amistoso',
            'Treino Tático',
            'Peneira Sub-17',
            'Peneira Sub-20',
            'Treino Físico',
            'Coletivo Principal',
            'Treino de Finalização',
            'Treino de Bola Parada',
        ];

        $cores = [null, '#FF0000', '#00AEEF', '#28A745', '#FFC107', '#6F42C1'];

        $agora = Carbon::now();
        $eventosCriar = [];

        for ($i = 1; $i <= 50; $i++) {
            $clubeId = $clubesIds[array_rand($clubesIds)];
            $local   = $locais[array_rand($locais)];

            $tituloBase = $titulos[array_rand($titulos)];
            $titulo     = $tituloBase . ' #' . $i;

            $descricao  = "Evento {$titulo} focado em desenvolvimento e observação de atletas.";

            // data/hora entre 15 dias atrás e 45 dias pra frente
            $start = $agora
                ->copy()
                ->addDays(rand(-15, 45))
                ->setHour(rand(8, 21))
                ->setMinute(0)
                ->setSecond(0);

            $end = $start->copy()->addHours(rand(1, 3));

            // limite de participantes: às vezes null, às vezes um número
            $limite = rand(0, 1) === 1 ? rand(10, 50) : null;

            // algumas cores padrão (ou null)
            $color = $cores[array_rand($cores)];

            // created_at / updated_at coerentes com a data do evento
            if ($start->lessThanOrEqualTo($agora)) {
                // Evento no passado: criado até 30 dias antes do início
                $createdAt = $start->copy()->subDays(rand(1, 30));
            } else {
                // Evento futuro: criado em algum momento nos últimos 30 dias
                $createdAt = $agora
                    ->copy()
                    ->subDays(rand(0, 30))
                    ->setHour(rand(8, 21))
                    ->setMinute(0)
                    ->setSecond(0);
            }

            // updated_at após o created_at, mas sem exagero
            $updatedAt = $createdAt->copy()->addDays(rand(0, 10));

            $eventosCriar[] = [
                'clube_id'             => $clubeId,
                'titulo'               => $titulo,
                'descricao'            => $descricao,
                'data_hora_inicio'     => $start,
                'data_hora_fim'        => $end,
                'cep'                  => $local['cep'],
                'estado'               => $local['estado'],
                'cidade'               => $local['cidade'],
                'bairro'               => $local['bairro'],
                'rua'                  => $local['rua'],
                'numero'               => (string) rand(10, 999),
                'complemento'          => 'Sala ' . rand(1, 10),
                'limite_participantes' => $limite,
                'color'                => $color,
                'created_at'           => $createdAt,
                'updated_at'           => $updatedAt,
            ];
        }

        Evento::insert($eventosCriar);
    }
}
