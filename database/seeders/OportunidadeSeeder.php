<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Oportunidade;
use App\Models\Esporte;
use App\Models\Posicao;
use App\Models\Clube;

class OportunidadeSeeder extends Seeder
{
    public function run(): void
    {
        $today = now()->toDateString();

        $esporte = Esporte::firstOrCreate(
            ['nomeEsporte' => 'Futebol'],
            ['descricaoEsporte' => 'Futebol — modalidade principal do projeto']
        );

        $lateral = Posicao::firstOrCreate([
            'nomePosicao' => 'Lateral Esquerdo',
            'idEsporte' => $esporte->id
        ]);

        $volante = Posicao::firstOrCreate([
            'nomePosicao' => 'Volante',
            'idEsporte' => $esporte->id
        ]);

        $atacante = Posicao::firstOrCreate([
            'nomePosicao' => 'Atacante',
            'idEsporte' => $esporte->id
        ]);

        $zagueiro = Posicao::firstOrCreate([
            'nomePosicao' => 'Zagueiro',
            'idEsporte' => $esporte->id
        ]);
        
        $meia = Posicao::firstOrCreate([
            'nomePosicao' => 'Meia',
            'idEsporte' => $esporte->id
        ]);

        $flamengo = Clube::where('nomeClube', 'CR Flamengo')->first();
        $saoPaulo = Clube::where('nomeClube', 'São Paulo FC')->first();
        $palmeiras = Clube::where('nomeClube', 'SE Palmeiras')->first();

        $oportunidades = [
            [
                'tituloOportunidades'       => 'Peneira Lateral-Esquerdo Sub-17 (Flamengo)',
                'descricaoOportunidades'    => 'Processo seletivo para lateral-esquerdo sub-17.',
                'datapostagemOportunidades' => $today,
                'esporte_id'                => $esporte->id,
                'posicoes_id'               => $lateral->id,
                'clube_id'                  => $flamengo->id,
            ],
            [
                'tituloOportunidades'       => 'Treino para Alas e Laterais (São Paulo FC)',
                'descricaoOportunidades'    => 'Treino aberto para alas e laterais.',
                'datapostagemOportunidades' => $today,
                'esporte_id'                => $esporte->id,
                'posicoes_id'               => $lateral->id,
                'clube_id'                  => $saoPaulo->id,
            ],
            [
                'tituloOportunidades'       => 'Teste para Atacantes — Finalização (Flamengo)',
                'descricaoOportunidades'    => 'Teste de finalização e jogo aéreo para atacantes.',
                'datapostagemOportunidades' => $today,
                'esporte_id'                => $esporte->id,
                'posicoes_id'               => $atacante->id,
                'clube_id'                  => $flamengo->id,
            ],
            [
                'tituloOportunidades'       => 'Captação Meia Ofensivo (Palmeiras)',
                'descricaoOportunidades'    => 'Captação para meia ofensivo.',
                'datapostagemOportunidades' => $today,
                'esporte_id'                => $esporte->id,
                'posicoes_id'               => $meia->id,
                'clube_id'                  => $palmeiras->id,
            ],
            [
                'tituloOportunidades'       => 'Avaliação para Zagueiros (São Paulo FC)',
                'descricaoOportunidades'    => 'Avaliação para zagueiros.',
                'datapostagemOportunidades' => $today,
                'esporte_id'                => $esporte->id,
                'posicoes_id'               => $zagueiro->id,
                'clube_id'                  => $saoPaulo->id,
            ],
        ];

        foreach ($oportunidades as $op) {
            Oportunidade::create($op);
        }
    }
}