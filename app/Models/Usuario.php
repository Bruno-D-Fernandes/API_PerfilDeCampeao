<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Esporte;
use App\Models\Posicao;
use App\Models\Categoria;
use App\Models\Perfil;
use App\Models\Inscricao;
use App\Models\Oportunidade;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';  


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "nomeCompletoUsuario",
        "dataNascimentoUsuario",
        "generoUsuario",
        "estadoUsuario",
        "cidadeUsuario",
        "alturaCm",
        "emailUsuario",
        "senhaUsuario",
        "confirmacaoSenhaUsuario",
        "pesoKg",
        "peDominante",
        "maoDominante"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senhaUsuario',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dataNascimentoUsuario' => 'date',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */

    
    public function getAuthPassword()
    {
        return $this->senhaUsuario;
    }

    public function perfis()
    {
        return $this->hasMany(Perfil::class, 'usuario_id');
    }
    public function posicoes()
    {
        return $this->belongsToMany(Posicao::class, 'usuario_posicoes', 'usuario_id', 'posicao_id');
    }

    public function inscricoes(){
        return $this->hasMany(Inscricao::class, 'usuario_id');
    }
    public function oportunidadesInscritas(){
        return $this->belongsToMany(Oportunidade::class, 'inscricoes', 'usuario_id', 'oportunidade_id')
            ->withPivot('status','mensagem')->withTimestamps();
    }

    public function listas()
    {
        return $this->belongsToMany(Lista::class, 'lista_usuario', 'usuario_id', 'lista_id')
            ->withTimestamps();
    }

}