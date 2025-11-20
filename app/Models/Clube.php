<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Esporte;
use App\Models\Usuario;
use App\Models\Lista;

class Clube extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const STATUS_ATIVO = 'ativo';
    const STATUS_PENDENTE = 'pendente';
    const STATUS_REJEITADO = 'rejeitado';
    const STATUS_BLOQUEADO = 'bloqueado';

    protected $table = 'clubes';

    protected $fillable = [
        'nomeClube',
        'cnpjClube',
        'emailClube',
        'cidadeClube',
        'estadoClube',
        'anoCriacaoClube',
        'enderecoClube',
        'bioClube',
        'senhaClube',
        'fotoPerfilClube',
        'fotoBannerClube',
        'categoria_id',
        'esporte_id',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
        'bloque_reason',
    ];

    protected $casts = [
        'anoCriacaoClube' => 'date:Y-m-d',
        'reviewed_at' => 'datetime',
    ];

    protected $hidden = [
        'senhaClube',
        'remember_token',
        'cnpjClube',
    ];


    public function reviewer()
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    public function scopeAtivos($query)
    {
        return $query->where('status', self::STATUS_ATIVO);
    }
    public function scopePendentes($query)
    {
        return $query->where('status', self::STATUS_PENDENTE);
    }
    public function scopeRejeitados($query){
        return $query->where('status', self::STATUS_REJEITADO);
    }
    public function scopeBloqueados($query){
        return $query->where('status', self::STATUS_BLOQUEADO);
    }

    public function esporte()
    {
        return $this->belongsTo(Esporte::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function membros()
    {
        return $this->belongsToMany(Usuario::class, 'clubes_usuario', 'clube_id')->withPivot('esporte_id', 'funcao_id');
    }

    public function seguidores()
    {
        return $this->morphToMany(Usuario::class, 'seguivel', 'seguidores', null, 'seguivel_id');
    }

    public function listas()
    {
        return $this->hasMany(Lista::class, 'clube_id');
    }

    public function oportunidades()
    {
        return $this->hasMany(Oportunidade::class, 'clube_id');
    }
}
