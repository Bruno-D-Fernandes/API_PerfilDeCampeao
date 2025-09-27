<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posicao extends Model
{
    use HasFactory;

    protected $table = 'posicoes';

    protected $fillable = [
        'nomePosicao',
        'idEsporte',
    ];

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'perfil_posicao')
            ->withTimestamps();
    }
}
