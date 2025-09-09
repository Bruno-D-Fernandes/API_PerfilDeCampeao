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

    protected $fillable = [
        'idUsuario',    
        'textoPostagem',
        'localizacaoPostagem'
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'postagens_tags', 'idPostagem', 'idTag');
    }

    public function imagens()
    {
        return $this->hasMany(PostsImagem::class, 'idPostagem');
    }
}
