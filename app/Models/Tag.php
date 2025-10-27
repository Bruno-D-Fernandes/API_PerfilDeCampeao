<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Postagem;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $hidden = ['created_at', 'updated_at'];


    protected $fillable = [
        'nomeTag'
    ];


    public function postagens()
    {
        return $this->belongsToMany(Postagem::class, 'postagens_tags', 'idTag', 'idPostagem');
    }
}
