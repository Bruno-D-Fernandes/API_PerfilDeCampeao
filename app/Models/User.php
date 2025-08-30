<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'tbusuario';

    protected $fillable = [
        'nomeCompletoUsuario',
        'nomeUsuario',
        'emailUsuario',
        'senhaUsuario',
        'nacionalidadeUsuario',
        'dataNascimentoUsuario',
        'dataCadastroUsuario',
        'fotoPerfilUsuario',
        'fotoBannerUsuario',
        'bioUsuario',
        'alturaCm',
        'pesoKg',
        'peDominante',
        'maoDominante',
    ];

    protected $hidden = [
        'senhaUsuario',
        'remember_token',
    ];

    public function getAuthPassword()
    {
    return $this->senhaUsuario;
    }

}