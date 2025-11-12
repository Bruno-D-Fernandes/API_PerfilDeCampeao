<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Esporte;
use App\Models\Usuario;
use App\Models\Lista;

class Clube extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'clubes';

    protected $fillable = [
        'nomeClube',
        'cnpjClube',
        'emailClube',
        'cidadeClube',
        'estadoClube',
        'anoCriacaoClube',
        'enderecoClube',
        'bioClube',
        'senhaClube',
        'fotoPerfilClube',
        'fotoBannerClube',
    ];

    protected $hidden = [
        'senhaClube',
        'remember_token',
        'cnpjClube',
    ];

    //kk --Bruno 

    function esportes()
    {
        return $this->belongsToMany(Esporte::class);
    }

    public function membros()
    {
        return $this->belongsToMany(Usuario::class, 'clubes_usuario', 'clube_id')->withPivot('esporte_id', 'funcao_id');
    }

    public function seguidores()
    {
        return $this->morphToMany(Usuario::class, 'seguivel', 'seguidores', null, 'seguivel_id');
    }

    public function listas()
    {
        return $this->hasMany(Lista::class, 'clube_id');
    }
}
