<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcao extends Model
{
    use HasFactory;

    protected $table = 'funcoes';

<<<<<<< HEAD
    protected $fillable = ['nomeFuncao', 'descricaoFuncao'];

    protected $hidden = ['created_at', 'updated_at'];
}
=======
    protected $fillable = ['nome', 'descricao'];
}
>>>>>>> 0f5df67393b76d4e8cf4cc9b10f241abf4fd489d
