<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    use HasFactory;

    protected $table = 'funcoes';

    protected $fillable = ['nomeFuncao', 'descricaoFuncao'];

    protected $hidden = ['created_at', 'updated_at'];
}
