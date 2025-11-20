<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    use HasFactory;

    const STATUS_ATIVO = 'ativo';
    const STATUS_DELETADO = 'deletado';

    protected $table = 'funcoes';

    protected $fillable = ['nome', 'descricao'];
}