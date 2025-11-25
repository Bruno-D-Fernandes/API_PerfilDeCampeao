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
        'categoria_id',
        'esporte_id'
    ];

    protected $hidden = [
        'senhaClube',
        'remember_token',
        'cnpjClube',
    ];

    protected $appends = ['name', 'avatar'];

    public function esporte()
    {
        return $this->belongsTo(Esporte::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
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

    public function oportunidades()
    {
        return $this->hasMany(Oportunidade::class, 'clube_id');
    }

    public function conversations()
    {
        return Conversation::where(function ($query) {
            $query->where('participant_one_id', $this->id)
                ->where('participant_one_type', self::class);
        })->orWhere(function ($query) {
            $query->where('participant_two_id', $this->id)
                ->where('participant_two_type', self::class);
        });
    }

    public function getNameAttribute()
    {
        return $this->nomeClube;
    }

    public function getAvatarAttribute()
    {
        return $this->fotoPerfilClube;
    }
}
