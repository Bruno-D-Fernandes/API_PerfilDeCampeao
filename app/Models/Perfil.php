<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfis';

    protected $fillable = [
        'usuario_id',
        'categoria_id',
        'posicao_id',
        'esporte_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function posicoes()
    {
        return $this->belongsToMany(Posicao::class, 'perfil_posicao')
            ->withTimestamps();
    }

    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'esporte_id');
    }

    public function caracteristicas()
    {
        return $this->belongsToMany(Caracteristica::class, 'perfil_caracteristicas') // revisar isso | ta certo
            ->withPivot('valor') // valor preenchido (peso, altura etc)
            ->withTimestamps();
    }
}
