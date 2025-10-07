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
        'nomeLista',
        'descricaoLista',
    ];

    public function clube ()
    {
        return $this->belongsTo(Clube::class, 'clube_id');
    }
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'lista_usuario', 'lista_id', 'usuario_id')
            ->withTimestamps();
    }
}
