<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clube;
use App\Models\Usuario;

class Lista extends Model
{
    use HasFactory;

    protected $table = 'listas';

    protected $fillable = [
        'nome',
        'descricao',
        'clube_id',
    ];

    public function clube()
    {
        return $this->belongsTo(\App\Models\Clube::class, 'clube_id');
    }

    public function usuarios()
    {
        return $this->belongsToMany(\App\Models\Usuario::class, 'lista_usuario', 'lista_id', 'usuario_id')
            ->withTimestamps();
    }
}
