<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Posicao extends Model
{
    use HasFactory;

    protected $table = 'posicoes';

    protected $fillable = [
        'nomePosicao',
        'idEsporte',
    ];

    function usuarios()
    {
        return $this->belongsToMany(Usuario::class);
    }
}
