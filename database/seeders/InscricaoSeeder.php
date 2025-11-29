<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inscricao;
use App\Models\Oportunidade;
use App\Models\Usuario;
use Carbon\Carbon;

class InscricaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuariosIds   = Usuario::pluck('id')->all();
        $oportunidades = Oportunidade::all();

        if (empty($usuariosIds) || $oportunidades->isEmpty()) {
            return;
        }

        $agora = Carbon::now();
        $batch = [];

        foreach ($oportunidades as $oportunidade) {
            // Usuários que já estão inscritos nessa oportunidade
            $usuariosJaInscritos = Inscricao::where('oportunidade_id', $oportunidade->id)
                ->pluck('usuario_id');

            $totalJaInscritos = $usuariosJaInscritos->count();

            // Limite da oportunidade (agora sempre tem, pelo seu seeder)
            $limite = $oportunidade->limite_inscricoes;

            // Se tiver limite e já bateu, pula
            if (!is_null($limite) && $totalJaInscritos >= $limite) {
                continue;
            }

            // Quantidade base desejada
            $qtdDesejada = rand(10, 40);
            $qtdDesejada = min($qtdDesejada, count($usuariosIds));

            // Se tiver limite, respeita o espaço restante
            if (!is_null($limite)) {
                $limiteRestante = $limite - $totalJaInscritos;

                if ($limiteRestante <= 0) {
                    continue;
                }

                $qtdDesejada = min($qtdDesejada, $limiteRestante);
            }

            if ($qtdDesejada <= 0) {
                continue;
            }

            // Sorteia usuários que AINDA NÃO estão inscritos nessa oportunidade
            $usuariosDisponiveis = collect($usuariosIds)->diff($usuariosJaInscritos);

            if ($usuariosDisponiveis->isEmpty()) {
                continue;
            }

            $usuariosSorteados = $usuariosDisponiveis
                ->shuffle()
                ->take($qtdDesejada);

            foreach ($usuariosSorteados as $usuarioId) {
                $status = rand(0, 1) === 0
                    ? Inscricao::STATUS_PENDING
                    : Inscricao::STATUS_APPROVED;

                $batch[] = [
                    'usuario_id'      => $usuarioId,
                    'oportunidade_id' => $oportunidade->id,
                    'status'          => $status,
                    'created_at'      => $agora,
                    'updated_at'      => $agora,
                ];
            }
        }

        if (!empty($batch)) {
            Inscricao::insert($batch);
        }
    }
}
