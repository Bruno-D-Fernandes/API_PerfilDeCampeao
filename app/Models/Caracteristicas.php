<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristica extends Model
{
    use HasFactory;

    protected $table = 'caracteristicas';

    protected $fillable = [
        'nome',
        'unidade_medida',
    ];

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'perfil_caracteristicas')
                    ->withPivot('valor')
                    ->withTimestamps();
    }
}

