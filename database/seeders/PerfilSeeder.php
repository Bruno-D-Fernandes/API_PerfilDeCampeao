<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Perfil;
use App\Models\Usuario;
use App\Models\Esporte;
use App\Models\Categoria;
use App\Models\Posicao;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios   = Usuario::all();
        $esportes   = Esporte::all();
        $categorias = Categoria::all();

        if ($usuarios->isEmpty() || $esportes->isEmpty() || $categorias->isEmpty()) {
            return;
        }

        foreach ($usuarios as $usuario) {

            // Se já tiver perfil, só pula (evita duplicar)
            $perfilExistente = Perfil::where('usuario_id', $usuario->id)->first();
            if ($perfilExistente) {
                continue;
            }

            // Esporte aleatório
            $esporte = $esportes->random();

            // Tenta pegar categorias ligadas ao esporte (caso Categoria tenha campo esporte_id)
            $categoriasDoEsporte = $categorias->where('esporte_id', $esporte->id);

            if ($categoriasDoEsporte->isNotEmpty()) {
                $categoria = $categoriasDoEsporte->random();
            } else {
                // fallback: qualquer categoria
                $categoria = $categorias->random();
            }

            // Cria o perfil para o usuário
            $perfil = Perfil::create([
                'usuario_id'   => $usuario->id,
                'categoria_id' => $categoria->id,
                'esporte_id'   => $esporte->id,
            ]);

            // ----- VINCULA POSIÇÕES (opcional, mas já deixei pronto) -----
            // Pega posições relacionadas ao esporte (usa coluna idEsporte, como nas outras partes do sistema)
            $posicoesIds = Posicao::where('idEsporte', $esporte->id)
                ->pluck('id')
                ->all();

            if (!empty($posicoesIds)) {
                // Entre 1 e 3 posições distintas, sem passar do total
                $qtdPosicoes = rand(1, min(3, count($posicoesIds)));
                $keys        = (array) array_rand($posicoesIds, $qtdPosicoes);
                $escolhidas  = [];

                foreach ($keys as $k) {
                    $escolhidas[] = $posicoesIds[$k];
                }

                $perfil->posicoes()->sync($escolhidas);
            }
        }
    }
}
