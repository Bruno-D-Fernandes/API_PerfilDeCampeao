<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

     protected $fillable = [
        'clube_id',
        'titulo',
        'descricao',
        'data_hora_inicio',
        'data_hora_fim',
        'cep',
        'estado',
        'cidade',
        'bairro',
        'rua',
        'numero',
        'complemento',
        'limite_participantes',
        'color',
    ];

    protected $casts = [
        'data_hora_inicio' => 'datetime',
        'data_hora_fim'    => 'datetime',
    ];

    public function clube()
    {
        return $this->belongsTo(Clube::class, 'clube_id');
    }

    public function convites()
    {
        return $this->hasMany(ConviteEvento::class, 'evento_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'evento_id');
    }

    public function getEnderecoFormatadoAttribute()
    {
        $parteRua = collect([
            $this->rua, 
            $this->numero
        ])->filter()->implode(', '); 

        if ($this->complemento) {
            $parteRua .= ', ' . $this->complemento;
        }

        $cidadeUf = collect([
            $this->cidade, 
            $this->estado
        ])->filter()->implode(' - ');

        return collect([
            $parteRua,
            $this->bairro,
            $cidadeUf,
            $this->cep
        ])->filter()->implode(', '); 
    }
}
