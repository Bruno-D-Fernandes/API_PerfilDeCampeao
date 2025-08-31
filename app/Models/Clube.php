<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Esporte;
use App\Models\Usuario;


class Clube extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'clubes';

    protected $fillable = [
        'nomeClube',
        'cidadeClube',
        'estadoClube',
        'anoCriacaoClube',
        'cnpjClube',
        'enderecoClube',
        'bioClube',
        'senhaClube',
    ];

    function esportes()
    {
        return $this->belongsToMany(Esporte::class);
    }
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class);
    }
}
