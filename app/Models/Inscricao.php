<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    protected $table = 'inscricoes';

    protected $fillable = [
        'oportunidade_id',
        'usuario_id',
        'status',

    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function oportunidade()
    {
        return $this->belongsTo(Oportunidade::class);
    }
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
