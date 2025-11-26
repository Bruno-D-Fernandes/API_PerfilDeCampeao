<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'message',
        'type',
        'evento_id',
        'convite_evento_id',
        'payload',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'payload' => 'array',

    ];


    public function sender()
    {
        return $this->morphTo();
    }

    public function receiver()
    {
        return $this->morphTo();
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function conviteEvento()
    {
        return $this->belongsTo(ConviteEvento::class, 'convite_evento_id');
    }

    public function isConvite(): bool
    {
        return $this->type === 'convite';
    }
}
