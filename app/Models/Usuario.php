<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Usuario;
use App\Models\Clube;
use App\Models\Esporte;


class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'Usuario';  


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

            'nomeCompletoUsuario',
            'nomeUsuario',
            'emailUsuario',
            'senhaUsuario',
            'nacionalidadeUsuario',
            'dataNascimentoUsuario',
            'generoUsuario',
            'estadoUsuario',
            'cidadeUsuario',

            'dataCadastroUsuario',
            'bioUsuario',

            'alturaCm',
            'pesoKg',
            'peDominante',
            'maoDominante',
            'temporadasUsuario',

            //Fotos
            'fotoPerfilUsuario',
            'fotoBannerUsuario',
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

    public function posicoes()
    {
        return $this->belongsToMany(Posicao::class);
    }

   public function esportes()
    {
        return $this->belongsToMany(Esporte::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class);
    }
}