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

    protected $appends = ['sugestoes'];

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

    public function seguindo()
    {
        return $this->belongsToMany(Usuario::class, 'relacionamento_usuarios', 'usuario_seguidor_id', 'usuario_seguido_id');
    }

    public function seguidores()
    {
        return $this->belongsToMany(Usuario::class, 'relacionamento_usuarios', 'usuario_seguido_id', 'usuario_seguidor_id');
    }

    public function amigos()
    {
        $seguindoIds = $this->seguindo()->pluck('usuarios.id');
        return $this->seguidores()->whereIn('usuarios.id', $seguindoIds);
    }

    public function getSugestoesAttribute(): Collection
    {
        $excluirIds = $this->seguindo()->pluck('usuarios.id')->push($this->id)->all();

        $seguindoIds = $this->seguindo()->pluck('usuarios.id');

        if ($seguindoIds->isEmpty()) {
            return new Collection;
        }

        $sugestoesIds = DB::table('relacionamento_usuarios')
            ->whereIn('usuario_seguidor_id', $seguindoIds)
            ->pluck('usuario_seguido_id');

        return Usuario::whereIn('id', $sugestoesIds)
            ->whereNotIn('id', $excluirIds)
            ->inRandomOrder()
            ->limit(10)
            ->get();
    }
}