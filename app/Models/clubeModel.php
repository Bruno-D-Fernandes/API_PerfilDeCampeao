<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class clubeModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tbusuario';

    
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
}
