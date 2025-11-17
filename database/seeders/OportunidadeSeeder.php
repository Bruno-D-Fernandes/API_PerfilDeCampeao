<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Oportunidade;
use App\Models\Esporte;
use App\Models\Posicao;
use App\Models\Clube;
use Illuminate\Support\Facades\Hash;

class OportunidadeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{

		$today = now()->toDateString();

		$esporte = Esporte::firstOrCreate([
			'nomeEsporte' => 'Futebol'
		], [
			'descricaoEsporte' => 'Futebol — modalidade principal do projeto'
		]);

		$posicoes = [];
		$posicoes['lateral_esquerdo'] = Posicao::firstOrCreate([
			'nomePosicao' => 'Lateral Esquerdo',
			'idEsporte' => $esporte->id,
		]);
		$posicoes['volante'] = Posicao::firstOrCreate([
			'nomePosicao' => 'Volante',
			'idEsporte' => $esporte->id,
		]);
		$posicoes['atacante'] = Posicao::firstOrCreate([
			'nomePosicao' => 'Atacante',
			'idEsporte' => $esporte->id,
		]);
		$posicoes['zagueiro'] = Posicao::firstOrCreate([
			'nomePosicao' => 'Zagueiro',
			'idEsporte' => $esporte->id,
		]);
		$posicoes['meia'] = Posicao::firstOrCreate([
			'nomePosicao' => 'Meia',
			'idEsporte' => $esporte->id,
		]);

		$clubes = [
			[
				'nomeClube' => 'CR Flamengo',
				'cnpjClube' => '33.040.108/0001-90',
				'emailClube' => 'contato@flamengo.com.br',
				'cidadeClube' => 'Rio de Janeiro',
				'estadoClube' => 'RJ',
				'anoCriacaoClube' => '1895-11-17',
				'enderecoClube' => 'Av. Borges de Medeiros, 997',
				'bioClube' => 'Clube poliesportivo de referência nacional.',
				'senhaClube' => Hash::make('flamengo123'),
				'categoria_id' => 2,
				'esporte_id' => $esporte->id,
			],
			[
				'nomeClube' => 'São Paulo FC',
				'cnpjClube' => '60.567.697/0001-04',
				'emailClube' => 'contato@saopaulofc.com.br',
				'cidadeClube' => 'São Paulo',
				'estadoClube' => 'SP',
				'anoCriacaoClube' => '1930-01-25',
				'enderecoClube' => 'Praça Roberto Gomes Pedrosa, 1',
				'bioClube' => 'Clube focado em formação de atletas e alto rendimento.',
				'senhaClube' => Hash::make('saopaulo123'),
				'categoria_id' => 2,
				'esporte_id' => $esporte->id,
			],
			[
				'nomeClube' => 'SE Palmeiras',
				'cnpjClube' => '61.108.254/0001-50',
				'emailClube' => 'contato@palmeiras.com.br',
				'cidadeClube' => 'São Paulo',
				'estadoClube' => 'SP',
				'anoCriacaoClube' => '1914-08-26',
				'enderecoClube' => 'Rua Palestra Itália, 214',
				'bioClube' => 'Clube com forte presença nas categorias de base.',
				'senhaClube' => Hash::make('palmeiras123'),
				'categoria_id' => 2,
				'esporte_id' => $esporte->id,
			],
		];

		$clubesCriados = [];
		foreach ($clubes as $c) {
			$search = ['nomeClube' => $c['nomeClube']];
			$attrs = $c;
			unset($attrs['esporte_id'], $attrs['categoria_id']);

			$clube = Clube::firstOrCreate($search, $attrs);
			$changed = false;
			if (isset($c['categoria_id']) && ($clube->categoria_id ?? null) !== $c['categoria_id']) {
				$clube->categoria_id = $c['categoria_id'];
				$changed = true;
			}
			if (isset($c['esporte_id']) && ($clube->esporte_id ?? null) !== $c['esporte_id']) {
				$clube->esporte_id = $c['esporte_id'];
				$changed = true;
			}
			if ($changed) {
				$clube->save();
			}

			$clubesCriados[] = $clube;
		}

		// Extrair IDs para facilitar
		$flamengo = $clubesCriados[0];
		$saoPaulo = $clubesCriados[1];
		$palmeiras = $clubesCriados[2];


		$oportunidades = [
			[
				'descricaoOportunidades' => 'Processo seletivo para lateral-esquerdo sub-17 — foco em velocidade e recomposição defensiva.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['lateral_esquerdo']->id,
				'clube_id' => $flamengo->id,
				'idadeMinima' => 15,
				'idadeMaxima' => 17,
				'estadoOportunidade' => 'RJ',
				'cidadeOportunidade' => 'Rio de Janeiro',
				'enderecoOportunidade' => 'Centro de Treinamento George Helal',
				'cepOportunidade' => '22710-560',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Treino aberto para alas e laterais — ênfase em cruzamentos e apoio ofensivo.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['lateral_esquerdo']->id,
				'clube_id' => $saoPaulo->id,
				'idadeMinima' => 16,
				'idadeMaxima' => 19,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'São Paulo',
				'enderecoOportunidade' => 'Campo de Treino da Barra Funda',
				'cepOportunidade' => '01141-000',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Teste de finalização e jogo aéreo para atacantes — exigimos agilidade e precisão.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['atacante']->id,
				'clube_id' => $flamengo->id,
				'idadeMinima' => 18,
				'idadeMaxima' => 24,
				'estadoOportunidade' => 'RJ',
				'cidadeOportunidade' => 'Rio de Janeiro',
				'enderecoOportunidade' => 'Centro de Treinamento Ninho do Urubu',
				'cepOportunidade' => '22710-640',
				'status' => 'pending'
			],
			[
				'descricaoOportunidades' => 'Captação para meia ofensivo — criatividade e passes verticais valorizados.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['meia']->id,
				'clube_id' => $palmeiras->id,
				'idadeMinima' => 17,
				'idadeMaxima' => 22,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'São Paulo',
				'enderecoOportunidade' => 'Academia de Futebol do Palmeiras',
				'cepOportunidade' => '05038-110',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Avaliação para zagueiros — posicionamento e jogo de cabeça.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['zagueiro']->id,
				'clube_id' => $saoPaulo->id,
				'idadeMinima' => 18,
				'idadeMaxima' => 30,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'São Paulo',
				'enderecoOportunidade' => 'Centro de Treinamento Cotia',
				'cepOportunidade' => '06715-880',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Captação para jovens promessas (sub-14) — desenvolvimento técnico prioritário.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['atacante']->id,
				'clube_id' => $palmeiras->id,
				'idadeMinima' => 12,
				'idadeMaxima' => 14,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'São Paulo',
				'enderecoOportunidade' => 'Complexo de Treinamento Infantil',
				'cepOportunidade' => '05038-120',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Recrutamento de volantes com boa antecipação — condicionamento físico exigido.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['volante']->id,
				'clube_id' => $flamengo->id,
				'idadeMinima' => 19,
				'idadeMaxima' => 26,
				'estadoOportunidade' => 'RJ',
				'cidadeOportunidade' => 'Rio de Janeiro',
				'enderecoOportunidade' => 'CT do Flamengo - Unidade 2',
				'cepOportunidade' => '22710-600',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Treino seletivo para meias defensivos — passe curto e interceptação.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['meia']->id,
				'clube_id' => $flamengo->id,
				'idadeMinima' => 16,
				'idadeMaxima' => 21,
				'estadoOportunidade' => 'RJ',
				'cidadeOportunidade' => 'Rio de Janeiro',
				'enderecoOportunidade' => 'Campo Municipal de Treinos',
				'cepOportunidade' => '22710-999',
				'status' => 'pending'
			],
			[
				'descricaoOportunidades' => 'Avaliação física e técnica para laterais e alas — resistência e cruzamento.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['lateral_esquerdo']->id,
				'clube_id' => $palmeiras->id,
				'idadeMinima' => 17,
				'idadeMaxima' => 23,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'São Paulo',
				'enderecoOportunidade' => 'Centro de Treino Palmeiras - Campo B',
				'cepOportunidade' => '05038-111',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Convívio para atletas de linha — foco em versatilidade e técnica individual.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['atacante']->id,
				'clube_id' => $saoPaulo->id,
				'idadeMinima' => 15,
				'idadeMaxima' => 18,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'São Paulo',
				'enderecoOportunidade' => 'Centro Esportivo da Zona Leste',
				'cepOportunidade' => '03200-000',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Seleção para volante sub-20 — atleta com boa saída de bola e marcação agressiva.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['volante']->id,
				'clube_id' => $saoPaulo->id,
				'idadeMinima' => 17,
				'idadeMaxima' => 20,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'São Paulo',
				'enderecoOportunidade' => 'Centro de Formação de Cotia',
				'cepOportunidade' => '06715-880',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Avaliação técnica para atacante sub-15 — finalização, mobilidade e tomada rápida de decisão.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['atacante']->id,
				'clube_id' => $palmeiras->id,
				'idadeMinima' => 13,
				'idadeMaxima' => 15,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'São Paulo',
				'enderecoOportunidade' => 'Academia de Futebol do Palmeiras',
				'cepOportunidade' => '05038-110',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Captação de zagueiros adultos — experiência competitiva e força física são diferenciais.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['zagueiro']->id,
				'clube_id' => $flamengo->id,
				'idadeMinima' => 20,
				'idadeMaxima' => 32,
				'estadoOportunidade' => 'RJ',
				'cidadeOportunidade' => 'Rio de Janeiro',
				'enderecoOportunidade' => 'Ninho do Urubu',
				'cepOportunidade' => '22710-640',
				'status' => 'approved'
			],
			[
				'descricaoOportunidades' => 'Oportunidade para meia criativo — atletas com visão de jogo acima da média e passes verticais.',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicoes['meia']->id,
				'clube_id' => $saoPaulo->id,
				'idadeMinima' => 18,
				'idadeMaxima' => 25,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'São Paulo',
				'enderecoOportunidade' => 'CT da Barra Funda',
				'cepOportunidade' => '01141-000',
				'status' => 'approved'
			],
		];

		foreach ($oportunidades as $op) {
			Oportunidade::create($op);
		}
	}
}
