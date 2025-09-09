<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clube;
use App\Models\Usuario;
use App\Models\Posicao;


class Esporte extends Model
{
    use HasFactory;

    protected $table = 'esportes';

    protected $fillable = [
        'nomeEsporte',
        'descricaoEsporte',
    ];

    public function clubes()
    {
        return $this->belongsToMany(Clube::class);
    }
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuarios_esporte', 'esporte_id', 'usuario_id');
    }
    public function posicoes()
    {
        return $this->hasMany(Posicao::class);
    }
}
