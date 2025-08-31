<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Esporte;


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
    ];

    function esportes()
    {

        return $this->belongsToMany(Esporte::class);
    }
}
