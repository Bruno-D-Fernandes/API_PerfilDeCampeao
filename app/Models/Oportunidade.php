<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Oportunidade extends Model
{
    use HasFactory;

    protected $table = 'oportunidades';

    protected $fillable = [
        'descricaoOportunidades',
        'datapostagemOportunidades',
        'esporte_id',
        'posicoes_id',
        'clube_id',
    ];

    public function clube()
    {
        return $this->belongsTo(Clube::class, 'clube_id');
    }
    public function esporte()
    {
        return $this->belongsTo(Esporte::class, 'esporte_id');
    }
    public function posicoes()
    {
        return $this->belongsTo(Posicao::class, 'posicoes_id');
    }
}
