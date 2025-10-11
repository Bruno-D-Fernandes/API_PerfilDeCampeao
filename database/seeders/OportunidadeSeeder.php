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

		$esporte = Esporte::first();
		if (!$esporte) {
			$esporte = Esporte::create(['nomeEsporte' => 'Futebol']);
		}

		$posicao = Posicao::first();
		if (!$posicao) {
			$posicao = Posicao::create(['nomePosicao' => 'Atacante']);
		}

		$clube = Clube::where('nomeClube', 'Vasco')->first();
		if (!$clube) {

			$clube = Clube::firstOrCreate([
				'nomeClube' => 'Clube Exemplo'
			], [
				'cidadeClube' => 'São Paulo',
				'estadoClube' => 'SP',
				'anoCriacaoClube' => '2000-01-01',
				'cnpjClube' => '00.000.000/0000-00',
				'enderecoClube' => 'Rua Exemplo, 123',
				'bioClube' => 'Clube exemplo para seeds',
				'senhaClube' => Hash::make('senha123'),
			]);
		}

		$today = now()->toDateString();

		$oportunidades = [
			[
				'descricaoOportunidades' => 'Vaga para atacante juvenil - treino intensivo',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicao->id,
				'clube_id' => $clube->id,
				'idadeMinima' => 15,
				'idadeMaxima' => 18,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'São Paulo',
				'enderecoOportunidade' => 'Rua Exemplo, 10',
				'cepOportunidade' => '01311-000',
			],
			[
				'descricaoOportunidades' => 'Oportunidade para goleiro sub-20',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicao->id,
				'clube_id' => $clube->id,
				'idadeMinima' => 17,
				'idadeMaxima' => 20,
				'estadoOportunidade' => 'SP',
				'cidadeOportunidade' => 'Santos',
				'enderecoOportunidade' => 'Av. Teste, 45',
				'cepOportunidade' => '11010-000',
			],
			[
				'descricaoOportunidades' => 'Seleção aberta para meio-campo adulto',
				'datapostagemOportunidades' => $today,
				'esporte_id' => $esporte->id,
				'posicoes_id' => $posicao->id,
				'clube_id' => $clube->id,
				'idadeMinima' => 20,
				'idadeMaxima' => 30,
				'estadoOportunidade' => 'RJ',
				'cidadeOportunidade' => 'Rio de Janeiro',
				'enderecoOportunidade' => 'Praça Exemplo, 1',
				'cepOportunidade' => '20010-000',
			],
		];

		foreach ($oportunidades as $op) {
			Oportunidade::create($op);
		}
	}
}

