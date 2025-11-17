<?php

namespace Database\Seeders;

use App\Models\Funcao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FuncaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $funcoes = [
            // Funções de Atletas
            ['nome' => 'Jogador', 'descricao' => 'Atleta que participa ativamente nos jogos.'],

            // Funções da Comissão Técnica
            ['nome' => 'Técnico', 'descricao' => 'Responsável por treinar e gerir a equipe.'],
            ['nome' => 'Auxiliar Técnico', 'descricao' => 'Assiste o técnico principal nas suas funções.'],
            ['nome' => 'Preparador Físico', 'descricao' => 'Responsável pela condição física dos atletas.'],
            ['nome' => 'Fisioterapeuta', 'descricao' => 'Trata e previne lesões dos atletas.'],
            ['nome' => 'Médico', 'descricao' => 'Responsável pela saúde geral dos membros da equipe.'],
            ['nome' => 'Analista de Desempenho', 'descricao' => 'Analisa vídeos e dados para melhorar a performance.'],
            ['nome' => 'Olheiro', 'descricao' => 'Procura e avalia novos talentos para o clube.'],

            // Funções Administrativas
            ['nome' => 'Diretor Desportivo', 'descricao' => 'Responsável pelo planeamento e gestão do departamento de desporto.'],
            ['nome' => 'Presidente', 'descricao' => 'Máximo representante legal e administrativo do clube.'],
            ['nome' => 'Roupeiro', 'descricao' => 'Responsável pelos uniformes e equipamentos dos atletas.'],
        ];

        foreach ($funcoes as $funcao) {
            Funcao::firstOrCreate(['nome' => $funcao['nome']], $funcao);
        }
    }
}