<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clube;
use App\Models\Esporte;
use App\Models\Posicao;
use App\Models\Inscricao;
use App\Models\Usuario;

// Não é necessário herdar de Authenticatable ou usar HasApiTokens neste Model,
// pois ele é apenas um registro de dados, não um usuário logável.

class Oportunidade extends Model
{
    use HasFactory;

    protected $table = 'oportunidades';

    protected $fillable = [
        'descricaoOportunidades',
        'datapostagemOportunidades',
        'idadeMinima',
        'idadeMaxima',
        'estadoOportunidade',
        'cidadeOportunidade',
        'enderecoOportunidade',
        'cepOportunidade',
        'esporte_id',
        'posicoes_id',
        'clube_id',
    ];

    protected $casts = [
        'datapostagemOportunidades' => 'date:Y-m-d',
    ];
    public function clube()
    {
        // Certifique-se de que o caminho para o Model 'Clube' está correto
        return $this->belongsTo(Clube::class, 'clube_id');
    }

    /**
     * Relacionamento: Uma oportunidade é para um esporte.
     */
    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'esporte_id');
    }

    /**
     * Relacionamento: Uma oportunidade é para uma posição específica.
     */
    public function posicoes()
    {
        // Usando 'posicoes' para corresponder ao nome do campo 'posicoes_id'
        return $this->belongsTo(Posicao::class, 'posicoes_id');
    }
    public function inscricoes(){
        return $this->hasMany(Inscricao::class, 'oportunidade_id');
    }
    public function candidatos(){
        return $this->belongsToMany(Usuario::class, 'inscricoes', 'oportunidade_id', 'usuario_id')
            ->withPivot('status','mensagem')->withTimestamps();
    }
}