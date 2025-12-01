<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AtletaSeeder extends Seeder
{
    public function run(): void
    {
        $atletas = [];

        // Lista de estados/cidades para sortear
        $locais = [
            ['estado' => 'São Paulo',        'cidade' => 'São Paulo'],
            ['estado' => 'São Paulo',        'cidade' => 'Campinas'],
            ['estado' => 'São Paulo',        'cidade' => 'Santos'],
            ['estado' => 'Rio de Janeiro',   'cidade' => 'Rio de Janeiro'],
            ['estado' => 'Rio de Janeiro',   'cidade' => 'Niterói'],
            ['estado' => 'Minas Gerais',     'cidade' => 'Belo Horizonte'],
            ['estado' => 'Paraná',           'cidade' => 'Curitiba'],
            ['estado' => 'Bahia',            'cidade' => 'Salvador'],
            ['estado' => 'Pernambuco',       'cidade' => 'Recife'],
            ['estado' => 'Rio Grande do Sul','cidade' => 'Porto Alegre'],
            ['estado' => 'Ceará',            'cidade' => 'Fortaleza'],
            ['estado' => 'Santa Catarina',   'cidade' => 'Florianópolis'],
        ];

        for ($i = 1; $i <= 60; $i++) {
            $numero = str_pad((string) $i, 2, '0', STR_PAD_LEFT);

            $nome   = "Atleta {$numero}";
            $email  = "atleta{$numero}@example.com";

            $genero = $i % 2 === 0 ? 'Feminino' : 'Masculino';
            $peDominante  = $i % 3 === 0 ? 'esquerdo' : 'direito';
            $maoDominante = $i % 4 === 0 ? 'esquerda' : 'direita';

            $ano = 1990 + ($i % 15);
            $mes = (($i - 1) % 12) + 1;
            $dia = (($i - 1) % 28) + 1;
            $dataNascimento = sprintf('%04d-%02d-%02d', $ano, $mes, $dia);

            $altura = 160 + ($i % 25);
            $peso   = 55 + ($i % 30);

            $local = $locais[($i - 1) % count($locais)];

            $atletas[] = [
                'nomeCompletoUsuario'   => $nome,
                'emailUsuario'          => $email,
                'senhaUsuario'          => Hash::make('123456'),
                'dataNascimentoUsuario' => $dataNascimento,
                'fotoPerfilUsuario'     => "atleta_{$numero}_perfil.jpg",
                'fotoBannerUsuario'     => "atleta_{$numero}_banner.jpg",
                'bioUsuario'            => "Bio de {$nome} gerada automaticamente para testes.",
                'alturaCm'              => $altura,
                'pesoKg'                => $peso,
                'peDominante'           => $peDominante,
                'maoDominante'          => $maoDominante,
                'generoUsuario'         => $genero,
                'estadoUsuario'         => $local['estado'],
                'cidadeUsuario'         => $local['cidade'],
                'status'                => 'ativo',
            ];
        }

        DB::table('usuarios')->insert($atletas);
    }
}
