<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Postagem;

class PostsImagem extends Model
{
    use HasFactory;

    protected $table = 'posts_imagens';

    protected $fillable = [
        'idPostagem',
        'caminhoImagem'
    ];

    public function postagens()
    {
        return $this->hasMany(Postagem::class);
    }
}
