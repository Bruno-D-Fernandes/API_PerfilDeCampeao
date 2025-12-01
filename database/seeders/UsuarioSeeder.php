<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $agora = Carbon::now();

        // -----------------------------------------
        // LISTAS DE NOMES – aleatórios e variados
        // -----------------------------------------
        $firstMale = [
            "Lucas","João","Pedro","Rafael","Thiago","Bruno","Matheus","Gustavo",
            "Samuel","Daniel","Felipe","Victor","Alex","Igor","Henrique","Diego",
            "Marcelo","André","Rodrigo","Eduardo","Hugo","Caio","Murilo","Fernando",
            "Leandro","Renato","Fábio","Cauã","Nathan","Arthur","Ryan","Enzo",
        ];

        $firstFemale = [
            "Ana","Mariana","Letícia","Julia","Isabela","Camila","Larissa","Bianca",
            "Carolina","Emanuelle","Aline","Sophia","Luana","Heloísa","Bruna","Gabriela",
            "Vitória","Laura","Nicole","Paola","Manuela","Yasmin","Fernanda","Lorena",
            "Alice","Raquel","Stella","Lívia","Tainá","Nathalia","Caroline","Marina",
        ];

        $lastNames = [
            "Silva","Santos","Oliveira","Souza","Rodrigues","Fernandes","Almeida","Lima",
            "Araújo","Gomes","Costa","Barbosa","Mendes","Moura","Teixeira","Carvalho",
            "Rocha","Batista","Rezende","Monteiro","Nogueira","Pires","Ribeiro","Cardoso",
            "Dias","Freitas","Castro","Matos","Farias","Cavalcante","Vieira","Azevedo",
        ];

        // -----------------------------------------
        // LOCAIS (mantive os seus)
        // -----------------------------------------
        $locais = [
            ['estado' => 'São Paulo', 'cidade' => 'São Paulo'],
            ['estado' => 'São Paulo', 'cidade' => 'Campinas'],
            ['estado' => 'São Paulo', 'cidade' => 'Santos'],
            ['estado' => 'Rio de Janeiro', 'cidade' => 'Rio de Janeiro'],
            ['estado' => 'Rio de Janeiro', 'cidade' => 'Niterói'],
            ['estado' => 'Minas Gerais', 'cidade' => 'Belo Horizonte'],
            ['estado' => 'Paraná', 'cidade' => 'Curitiba'],
            ['estado' => 'Bahia', 'cidade' => 'Salvador'],
            ['estado' => 'Pernambuco', 'cidade' => 'Recife'],
            ['estado' => 'Rio Grande do Sul', 'cidade' => 'Porto Alegre'],
            ['estado' => 'Ceará', 'cidade' => 'Fortaleza'],
            ['estado' => 'Santa Catarina', 'cidade' => 'Florianópolis'],
        ];

        // -----------------------------------------
        // GERAR 200 USUÁRIOS
        // -----------------------------------------
        $usuarios = [];

        for ($i = 1; $i <= 200; $i++) {

            $genero = rand(0, 1) === 1 ? 'Masculino' : 'Feminino';

            $firstName = $genero === 'Masculino'
                ? $firstMale[array_rand($firstMale)]
                : $firstFemale[array_rand($firstFemale)];

            $lastName  = $lastNames[array_rand($lastNames)];

            $nome = "{$firstName} {$lastName}";

            // Email seguro (sem acentos e sem caracteres especiais)
            $emailBase = Str::ascii($nome);
            $emailBase = strtolower(preg_replace('/[^a-z0-9]/', '', $emailBase));
            $numero = str_pad($i, 3, '0', STR_PAD_LEFT);

            $email = "{$emailBase}{$numero}@example.com";

            // datas de nascimento variando (1985–2004)
            $ano = rand(1985, 2004);
            $mes = rand(1, 12);
            $dia = rand(1, 28);

            $dataNascimento = sprintf('%04d-%02d-%02d', $ano, $mes, $dia);

            // Local aleatório
            $local = $locais[array_rand($locais)];

            // altura e peso normais
            $altura = rand(160, 195);
            $peso   = rand(55, 95);

            $peDominante  = rand(0, 1) ? 'direito' : 'esquerdo';
            $maoDominante = rand(0, 1) ? 'direita' : 'esquerda';

            // created_at / updated_at -> entre agora e 6 meses atrás
            $createdAt = Carbon::now()
                ->copy()
                ->subMonths(rand(0, 5))
                ->subDays(rand(0, 27))
                ->setHour(rand(7, 22))
                ->setMinute(rand(0, 59))
                ->setSecond(0);

            $usuarios[] = [
                'nomeCompletoUsuario'     => $nome,
                'emailUsuario'            => $email,
                'senhaUsuario'            => Hash::make('123456'),
                'dataNascimentoUsuario'   => $dataNascimento,
                'fotoPerfilUsuario'       => "usuario_perfil.jpg",
                'fotoBannerUsuario'       => "usuario_banner.jpg",
                'alturaCm'                => $altura,
                'pesoKg'                  => $peso,
                'peDominante'             => $peDominante,
                'maoDominante'            => $maoDominante,
                'generoUsuario'           => $genero,
                'estadoUsuario'           => $local['estado'],
                'cidadeUsuario'           => $local['cidade'],
                'status'                  => 'ativo',
                'created_at'              => $createdAt,
                'updated_at'              => $createdAt,
            ];
        }

        DB::table('usuarios')->insert($usuarios);
    }
}
