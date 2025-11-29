<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Oportunidade;
use App\Models\Esporte;
use App\Models\Posicao;
use App\Models\Clube;
use Carbon\Carbon;

class OportunidadeSeeder extends Seeder
{
    public function run(): void
    {
        $clubes   = Clube::pluck('id')->all();
        $esportes = Esporte::all();

        if (empty($clubes) || $esportes->isEmpty()) {
            return;
        }

        // mapa: esporte_id => [posicao_ids...]
        $posicoesPorEsporte = [];
        foreach ($esportes as $esporte) {
            $posicoesPorEsporte[$esporte->id] = Posicao::where('idEsporte', $esporte->id)
                ->pluck('id')
                ->all();
        }

        // mapa: posicao_id => nomePosicao (pra montar título bonitinho)
        $mapPosicoes = Posicao::pluck('nomePosicao', 'id')->all();

        $titulosBase = [
            'Avaliação de novos talentos',
            'Peneira oficial',
            'Treino teste para elenco',
            'Seleção para categoria de base',
            'Projeto de desenvolvimento de atletas',
            'Avaliação técnica de atletas',
            'Observação de jogadores',
            'Treino específico para posição',
            'Semana de testes',
            'Captação de atletas',
        ];

        for ($i = 1; $i <= 100; $i++) {
            // Clube sorteado
            $clubeId = $clubes[array_rand($clubes)];

            // Esporte sorteado que tenha ao menos uma posição
            $esporteEscolhido = null;
            $posicoes = [];
            $tentativas = 0;

            do {
                $esporteEscolhido = $esportes->random();
                $posicoes = $posicoesPorEsporte[$esporteEscolhido->id] ?? [];
                $tentativas++;
            } while (empty($posicoes) && $tentativas < 10);

            if (empty($posicoes)) {
                // Se não tiver posição pra esse esporte, pula
                continue;
            }

            // Entre 1 e 3 posições distintas
            $quantPosicoes = rand(1, min(3, count($posicoes)));
            $keysSorteadas = (array) array_rand($posicoes, $quantPosicoes);
            $posicoesIds   = [];

            foreach ($keysSorteadas as $k) {
                $posicoesIds[] = $posicoes[$k];
            }

            $posicaoPrincipalId   = $posicoesIds[0];
            $nomePosicaoPrincipal = $mapPosicoes[$posicaoPrincipalId] ?? 'Atleta';

            // Monta título decente
            $tituloBase = $titulosBase[array_rand($titulosBase)];
            $titulo     = sprintf(
                '%s - %s (%s)',
                $tituloBase,
                $esporteEscolhido->nomeEsporte,
                $nomePosicaoPrincipal
            );

            $descricao = 'Oportunidade para atletas interessados em ' . $esporteEscolhido->nomeEsporte .
                ' na posição de ' . $nomePosicaoPrincipal .
                '. Seleção organizada pelo clube para avaliação de novos talentos.';

            // Data de postagem entre 1 e 6 meses atrás
            $mesesAtras   = rand(1, 6);
            $diasExtras   = rand(0, 27);
            $dataPostagem = Carbon::now()
                ->copy()
                ->subMonths($mesesAtras)
                ->subDays($diasExtras)
                ->setHour(rand(8, 21))
                ->setMinute(rand(0, 59))
                ->setSecond(0);

            // Idades (às vezes null)
            $idadeMin = null;
            $idadeMax = null;

            if (rand(0, 1)) {
                $idadeMin = rand(12, 18);
                $idadeMax = rand($idadeMin + 1, $idadeMin + 10);
            }

            // Limite de inscrições (AGORA SEMPRE DEFINIDO)
            $limiteInscricoes = rand(10, 60);

            $oportunidade = Oportunidade::create([
                'limite_inscricoes'         => $limiteInscricoes,
                'tituloOportunidades'       => $titulo,
                'descricaoOportunidades'    => $descricao,
                'datapostagemOportunidades' => $dataPostagem,
                'esporte_id'                => $esporteEscolhido->id,
                'posicoes_id'               => $posicaoPrincipalId,
                'clube_id'                  => $clubeId,
                'status'                    => Oportunidade::STATUS_APPROVED,
                'idadeMinima'               => $idadeMin,
                'idadeMaxima'               => $idadeMax,
                'created_at'                => $dataPostagem,
                'updated_at'                => $dataPostagem,
            ]);

            // Posições vinculadas (pivot)
            $oportunidade->posicaoPivot()->sync($posicoesIds);
        }
    }
}
