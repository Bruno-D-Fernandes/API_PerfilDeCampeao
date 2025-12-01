<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    
    protected $table = 'inscricoes';

    protected $fillable = [
        'oportunidade_id',
        'usuario_id',
        'status',
        'mensagem',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

    public function oportunidade()
    {
        return $this->belongsTo(Oportunidade::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
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
