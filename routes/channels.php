<?php

use App\Models\Usuario;
use App\Models\Clube;
use App\Models\Admin;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Canal de Usuário
Broadcast::channel('notifications.user.{id}', function ($model, $id) {
    return ($model instanceof Usuario) && ((int) $model->id === (int) $id);
});

// Canal de Clube
Broadcast::channel('notifications.club.{id}', function ($model, $id) {
    return ($model instanceof Clube) && ((int) $model->id === (int) $id);
});

// Canal de Admin
Broadcast::channel('notifications.admin', function ($model) {
    return ($model instanceof Admin);
});