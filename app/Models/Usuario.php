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
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';  

    protected $appends = ['amigos', 'sugestoes'];

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

    public function getAmigosAttribute()
    {
        $seguindoIds = $this->seguindoUsuarios()->pluck('usuarios.id');
        return $this->seguidores()->whereIn('usuarios.id', $seguindoIds)->get();
    }

    public function getSugestoesAttribute()
    {
        $seguindoIds = $this->seguindoUsuarios()->pluck('usuarios.id');

        if ($seguindoIds->isEmpty()) {
            return [
                'usuarios' => [],
                'clubes' => [],
            ];
        }

        $excluirUsuariosIds = $this->seguindoUsuarios()->pluck('usuarios.id')->push($this->id)->all();
        $sugestoesUsuariosIds = DB::table('seguidores')
            ->whereIn('usuario_id', $seguindoIds)
            ->where('seguivel_type', Usuario::class)
            ->distinct()
            ->pluck('seguivel_id');
        $sugerirUsuarios = Usuario::whereIn('id', $sugestoesUsuariosIds)
            ->whereNotIn('id', $excluirUsuariosIds)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $excluirClubesIds = $this->seguindoClubes()->pluck('clubes.id')->all();
        $sugestoesClubesIds = DB::table('seguidores')
            ->whereIn('usuario_id', $seguindoIds)
            ->where('seguivel_type', Clube::class)
            ->distinct()
            ->pluck('seguivel_id');
        $sugerirClubes = Clube::whereIn('id', $sugestoesClubesIds)
            ->whereNotIn('id', $excluirClubesIds)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return [
            'usuarios' => $sugerirUsuarios,
            'clubes' => $sugerirClubes,
        ];
    }
}