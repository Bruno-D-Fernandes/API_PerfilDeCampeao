<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Postagem;

class PostsImagem extends Model
{
    use HasFactory;

    protected $table = 'postagem_images';

    protected $fillable = [
        'idPostagem',
        'caminhoImagem'
    ];

    public function postagem()
    {
        return $this->belongsTo(Postagem::class, 'idPostagem');
    }
}
