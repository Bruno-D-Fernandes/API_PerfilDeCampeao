<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Database\Seeders\CategoriaSeeder;
use \Database\Seeders\EsporteSeeder;
use \Database\Seeders\PosicaoSeeder;
use \Database\Seeders\AdminSeeder;

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
        EsporteSeeder::class,
        PosicaoSeeder::class,
        CategoriaSeeder::class,
        CaracteristicaSeeder::class
    ]);
    }
}
