<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbusuario';

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
        'fotoPerfilUsuario',
        'fotoBannerUsuario',
        'bioUsuario',
        'alturaCm',
        'pesoKg',
        'peDominante',
        'maoDominante',
        'generoUsuario',
        'esporte',
        'posicao',
        'estadoUsuario',
        'cidadeUsuario',
        'categoria',
        'temporadasUsuario',
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
}