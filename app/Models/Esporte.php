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

    protected $fillable = [
        'nomeEsporte',
        'descricaoEsporte',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function clubes() // tirar isso depois | só estou mexendo no usuario -- bruno
    {
        return $this->hasMany(Clube::class);
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
