<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConviteEvento;
use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Support\Carbon;

class ConviteEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuariosIds = Usuario::pluck('id')->all();
        $eventos     = Evento::inRandomOrder()->limit(10)->get(); // 10 dos 50 eventos

        if (empty($usuariosIds) || $eventos->isEmpty()) {
            return;
        }

        $totalDesejado = 100;

        $convites = [];

        // controle por evento
        $convitesPorEventoAceitos = []; // conta só os ACEITOS
        $chavesUsadas = []; // evita (usuario_id, evento_id) repetido

        // pra sortear status
        $possiveisStatus = [
            ConviteEvento::STATUS_PENDENTE,
            ConviteEvento::STATUS_PENDENTE,
            ConviteEvento::STATUS_PENDENTE,
            ConviteEvento::STATUS_ACEITO,
            ConviteEvento::STATUS_ACEITO,
            ConviteEvento::STATUS_CANCELADO_PELO_CLUBE,
            ConviteEvento::STATUS_EXPIRADO,
        ];

        $maxTentativas = $totalDesejado * 20;
        $tentativas = 0;

        while (count($convites) < $totalDesejado && $tentativas < $maxTentativas) {
            $tentativas++;

            /** @var \App\Models\Evento $evento */
            $evento   = $eventos->random();
            $eventoId = $evento->id;
            $limite   = $evento->limite_participantes; // pode ser null

            $usuarioId = $usuariosIds[array_rand($usuariosIds)];
            $chave = $usuarioId.'-'.$eventoId;

            // já existe convite desse usuário pra esse evento
            if (isset($chavesUsadas[$chave])) {
                continue;
            }

            // sorteia um status
            $status = $possiveisStatus[array_rand($possiveisStatus)];

            // se for ACEITO, respeita limite_participantes
            if ($status === ConviteEvento::STATUS_ACEITO && !is_null($limite)) {
                $qtdAceitosAtual = $convitesPorEventoAceitos[$eventoId] ?? 0;

                if ($qtdAceitosAtual >= $limite) {
                    // se já bateu o limite, transforma em pendente
                    $status = ConviteEvento::STATUS_PENDENTE;
                }
            }

            // datas baseadas na data do evento
            $dataEvento = Carbon::parse($evento->data_hora_inicio);

            // enviado de 2 a 15 dias antes do evento
            $sentAt = (clone $dataEvento)->subDays(rand(2, 15));
            if ($sentAt->greaterThan($dataEvento)) {
                $sentAt = (clone $dataEvento)->subDays(1);
            }

            // expira na data do evento
            $expiresAt = (clone $dataEvento);

            // responded_at só para status que não são pendentes
            $respondedAt = null;
            if ($status !== ConviteEvento::STATUS_PENDENTE) {
                $respondedAt = (clone $sentAt)->addDays(rand(0, 3))->min($dataEvento);
            }

            $createdAt = (clone $sentAt)->subMinutes(rand(0, 60));
            $updatedAt = $respondedAt ?? $sentAt;

            $convites[] = [
                'evento_id'   => $eventoId,
                'usuario_id'  => $usuarioId,
                'status'      => $status,
                'sent_at'     => $sentAt,
                'expires_at'  => $expiresAt,
                'responded_at'=> $respondedAt,
                'created_at'  => $createdAt,
                'updated_at'  => $updatedAt,
            ];

            // marca a combinação usuário+evento como usada
            $chavesUsadas[$chave] = true;

            // se status aceito, incrementa contador daquele evento
            if ($status === ConviteEvento::STATUS_ACEITO) {
                $convitesPorEventoAceitos[$eventoId] = ($convitesPorEventoAceitos[$eventoId] ?? 0) + 1;
            }
        }

        if (!empty($convites)) {
            ConviteEvento::insert($convites);
        }
    }
}
