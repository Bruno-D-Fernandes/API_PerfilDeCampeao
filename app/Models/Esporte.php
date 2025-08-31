<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clube;

class Esporte extends Model
{
    use HasFactory;

    protected $table = 'esportes';

    protected $fillable = [
        'nomeEsporte',
        'descricaoEsporte',
    ];

    function clubes()
    {
        return $this->belongsToMany(Clube::class);
    }
}
