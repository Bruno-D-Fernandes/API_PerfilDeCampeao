<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            [
                'email' => 'admin@sistema.com'
            ],
            [
                'nome' => 'Administrador Padrão',
                'password' => Hash::make('senha123'),
                'telefone' => '(11) 91234-5678',
                'endereco' => 'Rua da Plataforma, 123 - Centro, SP',
                'data_nascimento' => '1990-01-01',
                'foto_perfil' => null
            ]
        );
    }
}