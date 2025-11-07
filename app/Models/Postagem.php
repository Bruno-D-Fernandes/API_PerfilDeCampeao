<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Tag;
// use App\Models\Usuario;

class Postagem extends Model
{
    use HasFactory;

    protected $table = 'postagens';

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'idUsuario',
        'textoPostagem',
        'localizacaoPostagem',
        'esporte_id'
    ];

    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'esporte_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'postagens_tags', 'idPostagem', 'idTag');
    }

    public function imagens()
    {
        return $this->hasMany(PostsImagem::class, 'idPostagem');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario');
    }
}
