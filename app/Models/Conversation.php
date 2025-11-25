<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function participantOne()
    {
        return $this->morphTo();
    }

    public function participantTwo()
    {
        return $this->morphTo();
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class, 'conversation_id')
            ->latestOfMany();
    }
}
