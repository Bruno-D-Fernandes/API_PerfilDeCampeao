<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clube;
use App\Models\Esporte;
use App\Models\Posicao;
use App\Models\Inscricao;
use App\Models\Admin;
use App\Models\Usuario;

class Oportunidade extends Model
{
    use HasFactory;

    protected $table = 'oportunidades';
    protected $hidden = ['created_at', 'updated_at'];

    public const STATUS_PENDING  = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'tituloOportunidades',
        'descricaoOportunidades',
        'datapostagemOportunidades',
        'esporte_id',
        'clube_id',
        'idadeMinima',
        'idadeMaxima',
        'limite_inscricoes',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
    ];

    protected $casts = [
        'datapostagemOportunidades' => 'date:Y-m-d',
        'reviewed_at'               => 'datetime',
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
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    public function clube()
    {
        return $this->belongsTo(Clube::class, 'clube_id');
    }

    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'esporte_id');
    }

    public function posicoes()
    {
        return $this->belongsToMany(
            Posicao::class,
            'oportunidades_posicoes',
            'oportunidades_id',
            'posicoes_id'
        )->withTimestamps();
    }

    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'oportunidade_id');
    }

    public function inscricoesAprovadas()
    {
        return $this->hasMany(Inscricao::class, 'oportunidade_id')
                    ->where('status', self::STATUS_APPROVED);
    }

    public function inscricoesRejeitadas()
    {
        return $this->hasMany(Inscricao::class, 'oportunidade_id')
                    ->where('status', self::STATUS_REJECTED);
    }

    public function inscricoesPendentes()
    {
        return $this->hasMany(Inscricao::class, 'oportunidade_id')
                    ->where('status', self::STATUS_PENDING);
    }

    public function candidatos()
    {
        return $this->belongsToMany(Usuario::class, 'inscricoes', 'oportunidade_id', 'usuario_id')
            ->withPivot('status', 'mensagem')
            ->withTimestamps();
    }

    public function showHTMLStatus()
    {
        if ($this->status == self::STATUS_APPROVED) {
            return 'Aprovada';
        } elseif ($this->status == self::STATUS_REJECTED) {
            return 'Rejeitada';
        }

        return 'Pendente';
    }
}
