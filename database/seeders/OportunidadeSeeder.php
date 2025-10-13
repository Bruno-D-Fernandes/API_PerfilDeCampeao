<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Oportunidade;
use App\Models\Esporte;
use App\Models\Posicao;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OportunidadeSeeder extends Seeder
{
    public function run(): void
    {
        // Recupera esportes e posições existentes
        $futebol = Esporte::where('nomeEsporte', 'Futebol')->first();
        $volei = Esporte::where('nomeEsporte', 'Vôlei')->first();
        $basquete = Esporte::where('nomeEsporte', 'Basquete')->first();

        // Se alguma estiver faltando, evita erro
        if (!$futebol || !$volei || !$basquete) {
            $this->command->warn('⚠️ Alguns esportes não foram encontrados. Rode o EsporteSeeder e PosicaoSeeder primeiro.');
            return;
        }

        // Busca posições existentes por esporte
        $posFutebol = Posicao::where('idEsporte', $futebol->id)->inRandomOrder()->first();
        $posVolei = Posicao::where('idEsporte', $volei->id)->inRandomOrder()->first();
        $posBasquete = Posicao::where('idEsporte', $basquete->id)->inRandomOrder()->first();

        $oportunidades = [
            // Clube 1
            [
                'descricaoOportunidades' => 'Seleção para jogadores sub-18 de futebol.',
                'datapostagemOportunidades' => Carbon::now(),
                'esporte_id' => $futebol->id,
                'posicoes_id' => $posFutebol?->id,
                'clube_id' => 1,
                'idadeMinima' => 16,
                'idadeMaxima' => 18,
                'estadoOportunidade' => 'SP',
                'cidadeOportunidade' => 'São Paulo',
                'enderecoOportunidade' => 'Av. Paulista, 1000',
                'cepOportunidade' => '01000-000',
            ],
            [
                'descricaoOportunidades' => 'Procura-se goleiro para categoria amadora de futebol.',
                'datapostagemOportunidades' => Carbon::now(),
                'esporte_id' => $futebol->id,
                'posicoes_id' => $posFutebol?->id,
                'clube_id' => 1,
                'idadeMinima' => 18,
                'idadeMaxima' => 25,
                'estadoOportunidade' => 'SP',
                'cidadeOportunidade' => 'Campinas',
                'enderecoOportunidade' => 'Rua das Flores, 45',
                'cepOportunidade' => '13000-200',
            ],

            // Clube 2
            [
                'descricaoOportunidades' => 'Seleção de novos jogadores de vôlei masculino.',
                'datapostagemOportunidades' => Carbon::now(),
                'esporte_id' => $volei->id,
                'posicoes_id' => $posVolei?->id,
                'clube_id' => 2,
                'idadeMinima' => 17,
                'idadeMaxima' => 22,
                'estadoOportunidade' => 'RJ',
                'cidadeOportunidade' => 'Rio de Janeiro',
                'enderecoOportunidade' => 'Av. Atlântica, 500',
                'cepOportunidade' => '22000-000',
            ],
            [
                'descricaoOportunidades' => 'Procura-se levantador para equipe de vôlei universitário.',
                'datapostagemOportunidades' => Carbon::now(),
                'esporte_id' => $volei->id,
                'posicoes_id' => $posVolei?->id,
                'clube_id' => 2,
                'idadeMinima' => 19,
                'idadeMaxima' => 25,
                'estadoOportunidade' => 'RJ',
                'cidadeOportunidade' => 'Niterói',
                'enderecoOportunidade' => 'Rua do Esporte, 88',
                'cepOportunidade' => '24000-000',
            ],

            // Clube 3
            [
                'descricaoOportunidades' => 'Treinamento de jovens talentos no basquete feminino.',
                'datapostagemOportunidades' => Carbon::now(),
                'esporte_id' => $basquete->id,
                'posicoes_id' => $posBasquete?->id,
                'clube_id' => 3,
                'idadeMinima' => 15,
                'idadeMaxima' => 20,
                'estadoOportunidade' => 'MG',
                'cidadeOportunidade' => 'Belo Horizonte',
                'enderecoOportunidade' => 'Rua da Arena, 300',
                'cepOportunidade' => '30100-000',
            ],
        ];

        foreach ($oportunidades as $dados) {
            Oportunidade::create($dados);
        }

        $this->command->info('✅ 5 oportunidades criadas com sucesso!');
    }
}
