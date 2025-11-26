<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clube;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClubeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clube exemplo que você já tinha
        Clube::firstOrCreate([
            'nomeClube' => 'Club de Regatas Vasco da Gama'
        ], [
            'nomeClube' => 'Club de Regatas Vasco da Gama',
            'cnpjClube' => '00.000.000/0001-91',
            'emailClube' => 'contato@vasco.com.br',
            'cidadeClube' => 'Rio de Janeiro',
            'estadoClube' => 'RJ',
            'anoCriacaoClube' => '1898-08-21',
            'enderecoClube' => 'São Januário, Rua General Almério de Moura 131',
            'bioClube' => 'Clube de futebol tradicional do Rio de Janeiro. Fundado em 1898, com foco em esporte e formação.',
            'senhaClube' => Hash::make('vasco123'),
            'categoria_id' => 2,
            'esporte_id' => 1,
            'fotoPerfilClube' => 'imagens_seeder/vasco_perfil.png',
            'status' => 'ativo'
        ]);

        // Flamengo
        Clube::firstOrCreate([
            'nomeClube' => 'CR Flamengo'
        ], [
            'nomeClube' => 'CR Flamengo',
            'cnpjClube' => '33.040.108/0001-90',
            'emailClube' => 'contato@flamengo.com.br',
            'cidadeClube' => 'Rio de Janeiro',
            'estadoClube' => 'RJ',
            'anoCriacaoClube' => '1895-11-17',
            'enderecoClube' => 'Av. Borges de Medeiros, 997 - Lagoa',
            'bioClube' => 'Clube poliesportivo conhecido principalmente pelo seu time de futebol.',
            'senhaClube' => Hash::make('mengao123'),
            'categoria_id' => 2,
            'esporte_id' => 1,
            'fotoPerfilClube' => 'imagens_seeder/flamengo_perfil.png'
        ]);

        // São Paulo FC
        Clube::firstOrCreate([
            'nomeClube' => 'São Paulo FC'
        ], [
            'nomeClube' => 'São Paulo FC',
            'cnpjClube' => '60.567.697/0001-04',
            'emailClube' => 'contato@saopaulofc.com.br',
            'cidadeClube' => 'São Paulo',
            'estadoClube' => 'SP',
            'anoCriacaoClube' => '1930-01-25',
            'enderecoClube' => 'Praça Roberto Gomes Pedrosa, 1 - Morumbi',
            'bioClube' => 'Um dos maiores clubes do Brasil, tricampeão mundial.',
            'senhaClube' => Hash::make('spfc123'),
            'categoria_id' => 2,
            'esporte_id' => 1,
            'fotoPerfilClube' => 'imagens_seeder/saopaulo_perfil.png'
        ]);

        // Palmeiras
        Clube::firstOrCreate([
            'nomeClube' => 'SE Palmeiras'
        ], [
            'nomeClube' => 'SE Palmeiras',
            'cnpjClube' => '61.108.254/0001-50',
            'emailClube' => 'contato@palmeiras.com.br',
            'cidadeClube' => 'São Paulo',
            'estadoClube' => 'SP',
            'anoCriacaoClube' => '1914-08-26',
            'enderecoClube' => 'Rua Palestra Itália, 214 – Água Branca',
            'bioClube' => 'Sociedade Esportiva Palmeiras, campeã continental com forte base esportiva.',
            'senhaClube' => Hash::make('porco123'),
            'categoria_id' => 2,
            'esporte_id' => 1,
            'fotoPerfilClube' => 'imagens_seeder/palmeiras_perfil.png'

        ]);

        // Grêmio
        Clube::firstOrCreate([
            'nomeClube' => 'Grêmio FBPA'
        ], [
            'nomeClube' => 'Grêmio FBPA',
            'cnpjClube' => '91.423.126/0001-49',
            'emailClube' => 'contato@gremio.net',
            'cidadeClube' => 'Porto Alegre',
            'estadoClube' => 'RS',
            'anoCriacaoClube' => '1903-09-15',
            'enderecoClube' => 'Av. Padre Cacique, 891 – Praia de Belas',
            'bioClube' => 'Clube tradicional do Rio Grande do Sul, campeão da América.',
            'senhaClube' => Hash::make('gremio123'),
            'categoria_id' => 2,
            'esporte_id' => 1,
            'fotoPerfilClube' => 'imagens_seeder/gremio_perfil.png'
        ]);

        // Santos
        Clube::firstOrCreate([
            'nomeClube' => 'Santos FC'
        ], [
            'nomeClube' => 'Santos FC',
            'cnpjClube' => '12.593.721/0001-00',
            'emailClube' => 'contato@santosfc.com.br',
            'cidadeClube' => 'Santos',
            'estadoClube' => 'SP',
            'anoCriacaoClube' => '1912-04-14',
            'enderecoClube' => 'Rua Princesa Isabel, 77 – Vila Belmiro',
            'bioClube' => 'Clube conhecido mundialmente por revelar Pelé e grandes talentos.',
            'senhaClube' => Hash::make('santos123'),
            'categoria_id' => 2,
            'esporte_id' => 1,
            'fotoPerfilClube' => 'imagens_seeder/santos_perfil.png'
        ]);
    }
}
