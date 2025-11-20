<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clube;
use App\Models\Usuario;

class Lista extends Model
{
    use HasFactory;

    const STATUS_ATIVO = 'ativo';
    const STATUS_DELETADO = 'deletado';

    protected $table = 'listas';

    protected $fillable = [
        'nome',
        'descricao',
        'clube_id',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];


    public function scopeAtivos($query)
    {
        return $query->where('status', self::STATUS_ATIVO);
    }
    public function scopeDeletados($query)
    {
        return $query->where('status', self::STATUS_DELETADO);
    }

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
