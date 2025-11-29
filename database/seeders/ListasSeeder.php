<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lista;
use App\Models\Clube;
use Carbon\Carbon;

class ListasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clubes = Clube::all();

        if ($clubes->isEmpty()) {
            return;
        }

        $agora = Carbon::now();

        $categoriasBase = [
            'Sub-13',
            'Sub-15',
            'Sub-17',
            'Sub-18',
            'Sub-20',
            'Profissional',
        ];

        $focos = [
            'Atletas em observação',
            'Potenciais titulares',
            'Reservas promissores',
            'Atletas para próxima peneira',
            'Atletas para teste físico',
            'Atletas para reforçar elenco',
            'Atletas com boa leitura tática',
            'Atletas com bom potencial técnico',
            'Atletas com perfil de liderança',
            'Atletas para desenvolvimento a longo prazo',
        ];

        $descricoesBase = [
            'Lista de atletas que chamaram atenção em avaliações recentes.',
            'Lista criada para acompanhamento de desempenho em treinos e jogos.',
            'Lista voltada a atletas que podem ser chamados para testes específicos.',
            'Lista de observação contínua para futuras oportunidades no clube.',
            'Lista destinada a monitorar evolução física e técnica dos atletas.',
            'Lista para atletas que se destacaram em peneiras anteriores.',
            'Lista de referência para convocações de amistosos e treinos fechados.',
            'Lista para análise detalhada em conjunto com a comissão técnica.',
            'Lista com foco em atletas com potencial de subir de categoria.',
            'Lista utilizada para organizar relatórios individuais de atletas.',
        ];

        $listasInserir = [];

        $idxCategoria  = 0;
        $idxFoco       = 0;
        $idxDescricao  = 0;

        foreach ($clubes as $clube) {
            for ($i = 1; $i <= 3; $i++) {
                $categoria = $categoriasBase[$idxCategoria % count($categoriasBase)];
                $foco      = $focos[$idxFoco % count($focos)];
                $descBase  = $descricoesBase[$idxDescricao % count($descricoesBase)];

                $nome = "{$categoria} - {$foco}";

                $descricao = $descBase . " Lista pertencente ao clube {$clube->nomeClube}, usada para organizar atletas que o clube deseja acompanhar mais de perto.";

                $listasInserir[] = [
                    'nome'       => $nome,
                    'descricao'  => $descricao,
                    'clube_id'   => $clube->id,
                    'status'     => Lista::STATUS_ATIVO,
                    'created_at' => $agora,
                    'updated_at' => $agora,
                ];

                $idxCategoria++;
                $idxFoco++;
                $idxDescricao++;
            }
        }

        if (!empty($listasInserir)) {
            Lista::insert($listasInserir);
        }
    }
}
