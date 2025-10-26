<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clube;
use App\Models\Usuario;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nomeCategoria',
        'descricaoCategoria',
    ];

    public function clubes()
    {
        return $this->hasMany(Clube::class);
    }

}
