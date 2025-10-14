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
            ['nomeFuncao' => 'Jogador', 'descricaoFuncao' => 'Atleta que participa ativamente nos jogos.'],

            // Funções da Comissão Técnica
            ['nomeFuncao' => 'Técnico', 'descricaoFuncao' => 'Responsável por treinar e gerir a equipa.'],
            ['nomeFuncao' => 'Auxiliar Técnico', 'descricaoFuncao' => 'Assiste o técnico principal nas suas funções.'],
            ['nomeFuncao' => 'Preparador Físico', 'descricaoFuncao' => 'Responsável pela condição física dos atletas.'],
            ['nomeFuncao' => 'Fisioterapeuta', 'descricaoFuncao' => 'Trata e previne lesões dos atletas.'],
            ['nomeFuncao' => 'Médico', 'descricaoFuncao' => 'Responsável pela saúde geral dos membros da equipe.'],
            ['nomeFuncao' => 'Analista de Desempenho', 'descricaoFuncao' => 'Analisa vídeos e dados para melhorar a performance.'],
            ['nomeFuncao' => 'Olheiro', 'descricaoFuncao' => 'Procura e avalia novos talentos para o clube.'],

            // Funções Administrativas
            ['nomeFuncao' => 'Diretor Desportivo', 'descricaoFuncao' => 'Responsável pelo planeamento e gestão do departamento de desporto.'],
            ['nomeFuncao' => 'Presidente', 'descricaoFuncao' => 'Máximo representante legal e administrativo do clube.'],
            ['nomeFuncao' => 'Roupeiro', 'descricaoFuncao' => 'Responsável pelos uniformes e equipamentos dos atletas.'],
        ];

        foreach ($funcoes as $funcao) {
            Funcao::firstOrCreate(['nomeFuncao' => $funcao['nomeFuncao']], $funcao);
        }
    }
}