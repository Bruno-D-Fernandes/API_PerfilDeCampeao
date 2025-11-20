<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clube;
use App\Models\Posicao;

class Esporte extends Model
{
    use HasFactory;

    protected $table = 'esportes';

    const STATUS_ATIVO = 'ativo';
    const STATUS_DELETADO = 'deletado';

    protected $fillable = [
        'nomeEsporte',
        'descricaoEsporte',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function clubes() // tirar isso depois | só estou mexendo no usuario -- bruno
    {
        return $this->hasMany(Clube::class);
    }

    public function scopeAtivos($query)
    {
        return $query->where('status', self::STATUS_ATIVO);
    }
    public function scopeDeletados($query)
    {
        return $query->where('status', self::STATUS_DELETADO);
    }

    public function posicoes()
    {
        return $this->hasMany(Posicao::class, 'idEsporte');
    }

    public function caracteristicas()
    {
        return $this->hasMany(Caracteristica::class, 'esporte_id');
    }
}
