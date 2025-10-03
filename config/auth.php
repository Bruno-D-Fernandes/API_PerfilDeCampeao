<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards (Guardiões)
    |--------------------------------------------------------------------------
    | Onde definimos os "guards" que controlam como a autenticação funciona.
    | O guard 'sanctum' usará o provider 'clubes' para encontrar o usuário pelo token.
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        // 💡 Ajuste CRUCIAL: O guard 'sanctum' agora usa o provider 'clubes'.
        'sanctum' => [
            'driver' => 'sanctum',
            'provider' => 'clubes', 
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers (Provedores de Usuários)
    |--------------------------------------------------------------------------
    | Aqui definimos quais Models representam usuários.
    */

    'providers' => [
        // Provider Padrão para Usuários (provavelmente sua tabela 'usuarios')
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Usuario::class,
        ],

        // 💡 NOVO: Provider para o Modelo Clube
        'clubes' => [
            'driver' => 'eloquent',
            'model' => App\Models\Clube::class, // Certifique-se de que o namespace do seu modelo Clube está correto
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */

    'password_timeout' => 10800,

];