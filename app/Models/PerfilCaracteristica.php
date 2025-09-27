<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PerfilCaracteristica extends Pivot
{
    protected $table = 'perfil_caracteristicas';

    protected $fillable = [
        'perfil_id',
        'caracteristica_id',
        'valor',
    ];
    // esse model é opcional, vamos ver se vai ser usado --bruno
}
