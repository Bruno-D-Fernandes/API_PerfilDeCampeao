<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lista;
use App\Models\Clube;
use App\Models\Usuario; // Model correto agora
use Carbon\Carbon;

class ListasSeeder extends Seeder
{
    public function run(): void
    {
        // Carrega clubes (assumindo que Clube tem 'esporte_id')
        $clubes = Clube::all();

        if ($clubes->isEmpty()) {
            return;
        }

        $agora = Carbon::now();

        $categoriasBase = ['Sub-13', 'Sub-15', 'Sub-17', 'Sub-18', 'Sub-20', 'Profissional'];
        
        $focos = [
            'Atletas em observação', 'Potenciais titulares', 'Reservas promissores',
            'Atletas para próxima peneira', 'Atletas para teste físico', 
            'Atletas para reforçar elenco', 'Atletas com boa leitura tática'
        ];

        $descricoesBase = [
            'Lista de destaque mensal.', 'Acompanhamento tático.',
            'Observação para pré-temporada.', 'Monitoramento de evolução.'
        ];

        $idxCategoria = 0;
        $idxFoco = 0;
        $idxDescricao = 0;

        foreach ($clubes as $clube) {
            
            // LOGICA DE FILTRO:
            // Pegar usuários ATIVOS que tenham um PERFIL com o mesmo esporte do clube.
            // Ajuste 'esporte_id' conforme o nome real da coluna no seu banco.
            $candidatosDoEsporte = Usuario::ativos() // Usa o escopo do seu model
                ->whereHas('perfis', function ($query) use ($clube) {
                    $query->where('esporte_id', $clube->esporte_id);
                })
                ->get();

            for ($i = 1; $i <= 3; $i++) {
                $categoria = $categoriasBase[$idxCategoria % count($categoriasBase)];
                $foco      = $focos[$idxFoco % count($focos)];
                $descBase  = $descricoesBase[$idxDescricao % count($descricoesBase)];

                // Cria a lista
                $lista = Lista::create([
                    'nome'       => "{$categoria} - {$foco}",
                    'descricao'  => $descBase . " Clube: {$clube->nomeClube}",
                    'clube_id'   => $clube->id,
                    'status'     => Lista::STATUS_ATIVO,
                    'created_at' => $agora,
                    'updated_at' => $agora,
                ]);

                // Sorteio e Vínculo
                if ($candidatosDoEsporte->count() > 0) {
                    // Pega entre 2 e 5 atletas aleatórios dessa modalidade
                    $qtd = rand(2, min(5, $candidatosDoEsporte->count()));
                    
                    $atletasSorteados = $candidatosDoEsporte->random($qtd);

                    // Usa o relacionamento 'usuarios' que criamos no passo 1
                    $lista->usuarios()->attach($atletasSorteados->pluck('id'));
                }

                $idxCategoria++;
                $idxFoco++;
                $idxDescricao++;
            }
        }
    }
}