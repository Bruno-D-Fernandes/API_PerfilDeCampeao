<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConviteEvento extends Model
{
    use HasFactory;

    public const STATUS_PENDENTE             = 'pendente';
    public const STATUS_ACEITO               = 'aceito';
    public const STATUS_EXPIRADO             = 'expirado';
    public const STATUS_CANCELADO_PELO_CLUBE = 'cancelado_pelo_clube';

    protected $table = 'convites_evento';

    protected $fillable = [
        'evento_id',
        'usuario_id',
        'status',
        'sent_at',
        'responded_at',
        'expires_at',
        'color',
    ];

    protected $casts = [
        'sent_at'      => 'datetime',
        'responded_at' => 'datetime',
        'expires_at'   => 'datetime',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'convite_evento_id');
    }

    public function scopeDoUsuario($query, int $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    // Aceitos = “ativos” para o calendário
    public function scopeAtivos($query)
    {
        return $query->where('status', self::STATUS_ACEITO);
    }

    public function scopePendentes($query)
    {
        return $query->where('status', self::STATUS_PENDENTE);
    }

    public function scopeExpirados($query)
    {
        return $query->where('status', self::STATUS_EXPIRADO);
    }

    public function scopeCanceladosPeloClube($query)
    {
        return $query->where('status', self::STATUS_CANCELADO_PELO_CLUBE);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDENTE;
    }

    public function isAccepted(): bool
    {
        return $this->status === self::STATUS_ACEITO;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRADO
            || (
                $this->status === self::STATUS_PENDENTE
                && $this->expires_at
                && now()->greaterThanOrEqualTo($this->expires_at)
            );
    }
}
