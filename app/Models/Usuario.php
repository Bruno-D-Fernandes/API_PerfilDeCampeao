<?php

namespace App\Models;

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
use Illuminate\Support\Facades\DB;

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
        "maoDominante",
        "fotoPerfilUsuario",
        "fotoBannerUsuario",
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

    public function clubes()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_id')->withPivot('esporte_id', 'funcao_id');
    }

    public function seguindoUsuarios()
    {
        return $this->morphedByMany(Usuario::class, 'seguivel', 'seguidores', 'usuario_id');
    }

    public function seguindoClubes()
    {
        return $this->morphedByMany(Clube::class, 'seguivel', 'seguidores', 'usuario_id');
    }

    public function seguidores()
    {
        return $this->morphToMany(Usuario::class, 'seguivel', 'seguidores', null, 'seguivel_id');
    }

    public function posicoes()
    {
        return $this->belongsToMany(Posicao::class, 'usuario_posicoes', 'usuario_id', 'posicao_id');
    }

    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'usuario_id');
    }

    public function oportunidadesInscritas()
    {
        return $this->belongsToMany(Oportunidade::class, 'inscricoes', 'usuario_id', 'oportunidade_id')
            ->withPivot('status','mensagem')->withTimestamps();
    }

    public function listas()
    {
        return $this->belongsToMany(Lista::class, 'lista_usuario', 'usuario_id', 'lista_id')
            ->withTimestamps();
    }

    public function amigos()
    {
        $seguindoIds = $this->seguindoUsuarios()->pluck('usuarios.id');
        return $this->seguidores()->whereIn('usuarios.id', $seguindoIds);
    }

    public function sugestoesQuery()
    {
        $seguindoIds = $this->seguindoUsuarios()->pluck('usuarios.id');

        if ($seguindoIds->isEmpty()) {
            return Usuario::whereRaw('0 = 1');
        }

        $excluirUsuariosIds = $this->seguindoUsuarios()->pluck('usuarios.id')->push($this->id)->all();
        $sugestoesUsuariosIds = DB::table('seguidores')
            ->whereIn('usuario_id', $seguindoIds)->where('seguivel_type', Usuario::class)
            ->distinct()->pluck('seguivel_id');
        
        $usuariosQuery = Usuario::whereIn('id', $sugestoesUsuariosIds)
            ->whereNotIn('id', $excluirUsuariosIds)
            ->select('id', 'nomeCompletoUsuario as nome', DB::raw("'usuario' as tipo"));

        $excluirClubesIds = $this->seguindoClubes()->pluck('clubes.id')->all();
        $sugestoesClubesIds = DB::table('seguidores')
            ->whereIn('usuario_id', $seguindoIds)->where('seguivel_type', Clube::class)
            ->distinct()->pluck('seguivel_id');

        $clubesQuery = Clube::whereIn('id', $sugestoesClubesIds)
            ->whereNotIn('id', $excluirClubesIds)
            ->select('id', 'nomeClube as nome', DB::raw("'clube' as tipo"));

        return $usuariosQuery->union($clubesQuery);
    }

    public function seguindoQuery()
    {
        $usuariosQuery = $this->seguindoUsuarios()
            ->select('id', 'nomeCompletoUsuario as nome', DB::raw("'usuario' as tipo"));

        $clubesQuery = $this->seguindoClubes()
            ->select('id', 'nomeClube as nome', DB::raw("'clube' as tipo"));

        return $usuariosQuery->union($clubesQuery);
    }
}