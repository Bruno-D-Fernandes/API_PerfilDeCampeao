<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clube;
use App\Models\Esporte;
use App\Models\Posicao;
use App\Models\Inscricao;
use App\Models\Adm;
use App\Models\Usuario;

// Não é necessário herdar de Authenticatable ou usar HasApiTokens neste Model,
// pois ele é apenas um registro de dados, não um usuário logável.

class Oportunidade extends Model
{
    use HasFactory;




    protected $table = 'oportunidades';

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';


    protected $fillable = [
        'descricaoOportunidades',
        'datapostagemOportunidades',
        'esporte_id',
        'posicoes_id',
        'clube_id',
        'idadeMinima',
        'idadeMaxima',
        'estadoOportunidade',
        'cidadeOportunidade',
        'enderecoOportunidade',
        'cepOportunidade',
        "status",
        "reviewed_by",
        "reviewed_at",
        "rejection_reason",
    ];

    protected $casts = [
        'datapostagemOportunidades' => 'date:Y-m-d',
        'reviewed_at'               => 'datetime'
    ];

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }
    
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
    public function scopeRejected($query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function reviewer()
    {
        return $this->belongsTo(Adm::class, 'reviewed_by');
    }

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
    public function posicao()
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