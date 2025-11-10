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

    protected $hidden = ['created_at', 'updated_at'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function posicao()
    {
        return $this->belongsTo(Posicao::class, 'posicao_id');
    }

    public function posicoes()
    {
        return $this->belongsToMany(Posicao::class)
            ->withPivot('perfil_id', 'posicao_id');
    }

    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'esporte_id');
    }

    public function caracteristicas()
    {
        return $this->belongsToMany(Caracteristica::class, 'perfil_caracteristicas')
            ->withPivot('valor');
    }

    public function postagens()
    {
        return $this->hasMany(Postagem::class, 'idUsuario', 'usuario_id')
            ->where('postagens.esporte_id', $this->esporte_id);
    }
}
