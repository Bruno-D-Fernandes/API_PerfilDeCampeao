<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Clube;
use Illuminate\Support\Facades\Hash;

class ClubeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vasco
        Clube::firstOrCreate([
            'nomeClube' => 'Club de Regatas Vasco da Gama',
        ], [
            'nomeClube'       => 'Club de Regatas Vasco da Gama',
            'cnpjClube'       => '00.000.000/0001-91',
            'emailClube'      => 'contato@vasco.com.br',
            'cidadeClube'     => 'Rio de Janeiro',
            'estadoClube'     => 'RJ',
            'anoCriacaoClube' => '1898-08-21',
            'enderecoClube'   => 'São Januário, Rua General Almério de Moura 131',
            'bioClube'        => 'Clube de futebol tradicional do Rio de Janeiro. Fundado em 1898, com foco em esporte e formação.',
            'senhaClube'      => Hash::make('vasco123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/vasco_perfil.png',
            'status'          => 'ativo',
        ]);

        // Flamengo
        Clube::firstOrCreate([
            'nomeClube' => 'CR Flamengo',
        ], [
            'nomeClube'       => 'CR Flamengo',
            'cnpjClube'       => '33.040.108/0001-90',
            'emailClube'      => 'contato@flamengo.com.br',
            'cidadeClube'     => 'Rio de Janeiro',
            'estadoClube'     => 'RJ',
            'anoCriacaoClube' => '1895-11-17',
            'enderecoClube'   => 'Av. Borges de Medeiros, 997 - Lagoa',
            'bioClube'        => 'Clube poliesportivo conhecido principalmente pelo seu time de futebol.',
            'senhaClube'      => Hash::make('mengao123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/flamengo_perfil.png',
            'status'          => 'ativo',
        ]);

        // São Paulo
        Clube::firstOrCreate([
            'nomeClube' => 'São Paulo FC',
        ], [
            'nomeClube'       => 'São Paulo FC',
            'cnpjClube'       => '60.567.697/0001-04',
            'emailClube'      => 'contato@saopaulofc.com.br',
            'cidadeClube'     => 'São Paulo',
            'estadoClube'     => 'SP',
            'anoCriacaoClube' => '1930-01-25',
            'enderecoClube'   => 'Praça Roberto Gomes Pedrosa, 1 - Morumbi',
            'bioClube'        => 'Um dos maiores clubes do Brasil, tricampeão mundial.',
            'senhaClube'      => Hash::make('spfc123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/saopaulo_perfil.png',
            'status'          => 'ativo',
        ]);

        // Palmeiras
        Clube::firstOrCreate([
            'nomeClube' => 'SE Palmeiras',
        ], [
            'nomeClube'       => 'SE Palmeiras',
            'cnpjClube'       => '61.108.254/0001-50',
            'emailClube'      => 'contato@palmeiras.com.br',
            'cidadeClube'     => 'São Paulo',
            'estadoClube'     => 'SP',
            'anoCriacaoClube' => '1914-08-26',
            'enderecoClube'   => 'Rua Palestra Itália, 214 – Água Branca',
            'bioClube'        => 'Sociedade Esportiva Palmeiras, campeã continental com forte base esportiva.',
            'senhaClube'      => Hash::make('porco123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/palmeiras_perfil.png',
            'status'          => 'ativo',
        ]);

        // Grêmio
        Clube::firstOrCreate([
            'nomeClube' => 'Grêmio FBPA',
        ], [
            'nomeClube'       => 'Grêmio FBPA',
            'cnpjClube'       => '91.423.126/0001-49',
            'emailClube'      => 'contato@gremio.net',
            'cidadeClube'     => 'Porto Alegre',
            'estadoClube'     => 'RS',
            'anoCriacaoClube' => '1903-09-15',
            'enderecoClube'   => 'Av. Padre Cacique, 891 – Praia de Belas',
            'bioClube'        => 'Clube tradicional do Rio Grande do Sul, campeão da América.',
            'senhaClube'      => Hash::make('gremio123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/gremio_perfil.png',
            'status'          => 'ativo',
        ]);

        // Santos (zona de rebaixamento -> pendente)
        Clube::firstOrCreate([
            'nomeClube' => 'Santos FC',
        ], [
            'nomeClube'       => 'Santos FC',
            'cnpjClube'       => '12.593.721/0001-00',
            'emailClube'      => 'contato@santosfc.com.br',
            'cidadeClube'     => 'Santos',
            'estadoClube'     => 'SP',
            'anoCriacaoClube' => '1912-04-14',
            'enderecoClube'   => 'Rua Princesa Isabel, 77 – Vila Belmiro',
            'bioClube'        => 'Clube conhecido mundialmente por revelar Pelé e grandes talentos.',
            'senhaClube'      => Hash::make('santos123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/santos_perfil.png',
            'status'          => 'pendente',
        ]);

        // Atlético-MG
        Clube::firstOrCreate([
            'nomeClube' => 'Clube Atlético Mineiro',
        ], [
            'nomeClube'       => 'Clube Atlético Mineiro',
            'cnpjClube'       => '11.111.111/0001-01',
            'emailClube'      => 'contato@atletico.com.br',
            'cidadeClube'     => 'Belo Horizonte',
            'estadoClube'     => 'MG',
            'anoCriacaoClube' => '1908-03-25',
            'enderecoClube'   => 'Av. Olegário Maciel, Belo Horizonte',
            'bioClube'        => 'Tradicional clube mineiro, conhecido como Galo.',
            'senhaClube'      => Hash::make('galo123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/atletico_mg_perfil.png',
            'status'          => 'ativo',
        ]);

        // Bahia
        Clube::firstOrCreate([
            'nomeClube' => 'EC Bahia',
        ], [
            'nomeClube'       => 'EC Bahia',
            'cnpjClube'       => '11.111.111/0001-02',
            'emailClube'      => 'contato@bahia.com.br',
            'cidadeClube'     => 'Salvador',
            'estadoClube'     => 'BA',
            'anoCriacaoClube' => '1931-01-01',
            'enderecoClube'   => 'Arena Fonte Nova, Salvador',
            'bioClube'        => 'Clube baiano com forte torcida no Nordeste.',
            'senhaClube'      => Hash::make('bahia123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/bahia_perfil.png',
            'status'          => 'ativo',
        ]);

        // Botafogo
        Clube::firstOrCreate([
            'nomeClube' => 'Botafogo FR',
        ], [
            'nomeClube'       => 'Botafogo FR',
            'cnpjClube'       => '11.111.111/0001-03',
            'emailClube'      => 'contato@botafogo.com.br',
            'cidadeClube'     => 'Rio de Janeiro',
            'estadoClube'     => 'RJ',
            'anoCriacaoClube' => '1904-08-12',
            'enderecoClube'   => 'Estádio Nilton Santos, Rio de Janeiro',
            'bioClube'        => 'Clube carioca tradicional, conhecido como Glorioso.',
            'senhaClube'      => Hash::make('bota123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/botafogo_perfil.png',
            'status'          => 'ativo',
        ]);

        // RB Bragantino
        Clube::firstOrCreate([
            'nomeClube' => 'RB Bragantino',
        ], [
            'nomeClube'       => 'RB Bragantino',
            'cnpjClube'       => '11.111.111/0001-04',
            'emailClube'      => 'contato@rbbragantino.com.br',
            'cidadeClube'     => 'Bragança Paulista',
            'estadoClube'     => 'SP',
            'anoCriacaoClube' => '1928-01-08',
            'enderecoClube'   => 'Estádio Nabi Abi Chedid, Bragança Paulista',
            'bioClube'        => 'Clube do interior paulista com projeto de futebol moderno.',
            'senhaClube'      => Hash::make('braga123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/bragantino_perfil.png',
            'status'          => 'ativo',
        ]);

        // Ceará
        Clube::firstOrCreate([
            'nomeClube' => 'Ceará SC',
        ], [
            'nomeClube'       => 'Ceará SC',
            'cnpjClube'       => '11.111.111/0001-05',
            'emailClube'      => 'contato@cearasc.com',
            'cidadeClube'     => 'Fortaleza',
            'estadoClube'     => 'CE',
            'anoCriacaoClube' => '1914-06-02',
            'enderecoClube'   => 'Arena Castelão, Fortaleza',
            'bioClube'        => 'Um dos principais clubes do Nordeste, conhecido como Vozão.',
            'senhaClube'      => Hash::make('ceara123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/ceara_perfil.png',
            'status'          => 'ativo',
        ]);

        // Corinthians
        Clube::firstOrCreate([
            'nomeClube' => 'SC Corinthians',
        ], [
            'nomeClube'       => 'SC Corinthians',
            'cnpjClube'       => '11.111.111/0001-06',
            'emailClube'      => 'contato@corinthians.com.br',
            'cidadeClube'     => 'São Paulo',
            'estadoClube'     => 'SP',
            'anoCriacaoClube' => '1910-09-01',
            'enderecoClube'   => 'Arena Corinthians, São Paulo',
            'bioClube'        => 'Um dos clubes mais populares do Brasil, conhecido como Timão.',
            'senhaClube'      => Hash::make('timao123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/corinthians_perfil.png',
            'status'          => 'ativo',
        ]);

        // Cruzeiro
        Clube::firstOrCreate([
            'nomeClube' => 'Cruzeiro EC',
        ], [
            'nomeClube'       => 'Cruzeiro EC',
            'cnpjClube'       => '11.111.111/0001-07',
            'emailClube'      => 'contato@cruzeiro.com.br',
            'cidadeClube'     => 'Belo Horizonte',
            'estadoClube'     => 'MG',
            'anoCriacaoClube' => '1921-01-02',
            'enderecoClube'   => 'Av. Olegário Maciel, Belo Horizonte',
            'bioClube'        => 'Clube mineiro multicampeão nacional e continental.',
            'senhaClube'      => Hash::make('cruzeiro123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/cruzeiro_perfil.png',
            'status'          => 'ativo',
        ]);

        // Fluminense
        Clube::firstOrCreate([
            'nomeClube' => 'Fluminense FC',
        ], [
            'nomeClube'       => 'Fluminense FC',
            'cnpjClube'       => '11.111.111/0001-08',
            'emailClube'      => 'contato@fluminense.com.br',
            'cidadeClube'     => 'Rio de Janeiro',
            'estadoClube'     => 'RJ',
            'anoCriacaoClube' => '1902-07-21',
            'enderecoClube'   => 'Laranjeiras, Rio de Janeiro',
            'bioClube'        => 'Tricolor carioca, clube tradicional do futebol brasileiro.',
            'senhaClube'      => Hash::make('flu123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/fluminense_perfil.png',
            'status'          => 'ativo',
        ]);

        // Fortaleza (zona de rebaixamento -> pendente)
        Clube::firstOrCreate([
            'nomeClube' => 'Fortaleza EC',
        ], [
            'nomeClube'       => 'Fortaleza EC',
            'cnpjClube'       => '11.111.111/0001-09',
            'emailClube'      => 'contato@fortalezaec.com.br',
            'cidadeClube'     => 'Fortaleza',
            'estadoClube'     => 'CE',
            'anoCriacaoClube' => '1918-10-18',
            'enderecoClube'   => 'Arena Castelão, Fortaleza',
            'bioClube'        => 'Clube cearense em ascensão no cenário nacional.',
            'senhaClube'      => Hash::make('fortaleza123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/fortaleza_perfil.png',
            'status'          => 'pendente',
        ]);

        // Internacional
        Clube::firstOrCreate([
            'nomeClube' => 'SC Internacional',
        ], [
            'nomeClube'       => 'SC Internacional',
            'cnpjClube'       => '11.111.111/0001-10',
            'emailClube'      => 'contato@internacional.com.br',
            'cidadeClube'     => 'Porto Alegre',
            'estadoClube'     => 'RS',
            'anoCriacaoClube' => '1909-04-04',
            'enderecoClube'   => 'Beira-Rio, Porto Alegre',
            'bioClube'        => 'Clube gaúcho com tradição em títulos nacionais e internacionais.',
            'senhaClube'      => Hash::make('inter123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/internacional_perfil.png',
            'status'          => 'ativo',
        ]);

        // Juventude (zona de rebaixamento -> pendente)
        Clube::firstOrCreate([
            'nomeClube' => 'EC Juventude',
        ], [
            'nomeClube'       => 'EC Juventude',
            'cnpjClube'       => '11.111.111/0001-11',
            'emailClube'      => 'contato@juventude.com.br',
            'cidadeClube'     => 'Caxias do Sul',
            'estadoClube'     => 'RS',
            'anoCriacaoClube' => '1913-06-29',
            'enderecoClube'   => 'Estádio Alfredo Jaconi, Caxias do Sul',
            'bioClube'        => 'Clube do interior gaúcho com tradição no futebol brasileiro.',
            'senhaClube'      => Hash::make('juventude123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/juventude_perfil.png',
            'status'          => 'pendente',
        ]);

        // Mirassol
        Clube::firstOrCreate([
            'nomeClube' => 'Mirassol FC',
        ], [
            'nomeClube'       => 'Mirassol FC',
            'cnpjClube'       => '11.111.111/0001-12',
            'emailClube'      => 'contato@mirassolfc.com.br',
            'cidadeClube'     => 'Mirassol',
            'estadoClube'     => 'SP',
            'anoCriacaoClube' => '1925-11-10',
            'enderecoClube'   => 'Estádio José Maria de Campos Maia, Mirassol',
            'bioClube'        => 'Clube do interior paulista em sua primeira participação na elite.',
            'senhaClube'      => Hash::make('mirassol123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/mirassol_perfil.png',
            'status'          => 'ativo',
        ]);

        // Sport (zona de rebaixamento -> pendente)
        Clube::firstOrCreate([
            'nomeClube' => 'Sport Club do Recife',
        ], [
            'nomeClube'       => 'Sport Club do Recife',
            'cnpjClube'       => '11.111.111/0001-13',
            'emailClube'      => 'contato@sportrecife.com.br',
            'cidadeClube'     => 'Recife',
            'estadoClube'     => 'PE',
            'anoCriacaoClube' => '1905-05-13',
            'enderecoClube'   => 'Ilha do Retiro, Recife',
            'bioClube'        => 'Leão da Ilha, tradicional clube pernambucano.',
            'senhaClube'      => Hash::make('sport123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/sport_perfil.png',
            'status'          => 'pendente',
        ]);

        // Vitória
        Clube::firstOrCreate([
            'nomeClube' => 'EC Vitória',
        ], [
            'nomeClube'       => 'EC Vitória',
            'cnpjClube'       => '11.111.111/0001-14',
            'emailClube'      => 'contato@ecvitoria.com.br',
            'cidadeClube'     => 'Salvador',
            'estadoClube'     => 'BA',
            'anoCriacaoClube' => '1899-05-13',
            'enderecoClube'   => 'Barradão, Salvador',
            'bioClube'        => 'Clube baiano com tradição no Nordeste.',
            'senhaClube'      => Hash::make('vitoria123'),
            'categoria_id'    => 2,
            'esporte_id'      => 1,
            'fotoPerfilClube' => 'imagens_seeder/vitoria_perfil.png',
            'status'          => 'ativo',
        ]);
    }
}
