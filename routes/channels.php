<?php

use App\Models\Usuario;
use App\Models\Clube;
use App\Models\Admin;
use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;

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
Broadcast::channel('notification.user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


// Canal de Clube
Broadcast::channel('notifications.club.{id}', function ($model, $id) {
    return ($model instanceof Clube) && ((int) $model->id === (int) $id);
});

// Canal de Admin
Broadcast::channel('notifications.admin', function ($model) {
    return ($model instanceof Admin);
});

// routes/channels.php

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $conversation = App\Models\Conversation::find($conversationId);

    if (!$conversation) {
        return false;
    }

    $userType = $user->getMorphClass();

    $isParticipantOne = $user->id == $conversation->participant_one_id &&
        $userType == $conversation->participant_one_type;

    $isParticipantTwo = $user->id == $conversation->participant_two_id &&
        $userType == $conversation->participant_two_type;

    return $isParticipantOne || $isParticipantTwo;
});
