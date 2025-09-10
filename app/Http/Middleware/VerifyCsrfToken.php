<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */

    /* ALGUÉM ME LEMBRA DE TIRAR POR FAVOR!!!! */ 

    // Tirei. Não está explicito qual merge com qual web era pra tirar --ass: Bruno
   /* protected $except = [
        'api/usuario/update/*',
        'api/usuario/delete/*',
    ];*/
}
