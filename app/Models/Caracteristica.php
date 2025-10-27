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

    protected $hidden = ['created_at', 'updated_at'];

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'perfil_caracteristicas')
            ->withPivot('valor')
            ->withTimestamps();
    }

    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'esporte_id');
    }
}
