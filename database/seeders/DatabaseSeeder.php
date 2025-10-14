<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use \Database\Seeders\CategoriaSeeder;
use \Database\Seeders\EsporteSeeder;
use \Database\Seeders\PosicaoSeeder;
use \Database\Seeders\AdminSeeder;
use \Database\Seeders\ClubeSeeder;
use \Database\Seeders\AtletaSeeder;
use \Database\Seeders\OportunidadeSeeder;
use \Database\Seeders\InscricaoSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
        AdminSeeder::class,
        UsuarioSeeder::class,
        EsporteSeeder::class,
        PosicaoSeeder::class,
        CategoriaSeeder::class,
        CaracteristicaSeeder::class,
        ClubeSeeder::class,
        OportunidadeSeeder::class,
        InscricaoSeeder::class,
        FuncaoSeeder::class,
        ]);
    }
}
