<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Perfil;
use App\Models\Usuario;

class Posicao extends Model
{
    use HasFactory;

    protected $table = 'posicoes';

    protected $fillable = [
        'nomePosicao',
        'idEsporte',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'idEsporte');
    }
    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'perfil_posicao')
            ->withTimestamps();
    }

    public function usuarios()
    {
        return $this->belongsToMany(\App\Models\Usuario::class, 'usuario_posicoes', 'posicao_id', 'usuario_id')
            ->withTimestamps();
    }
}
