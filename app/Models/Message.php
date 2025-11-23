<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'type',
        'is_read',
        'evento_id',
        'convite_evento_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function sender()
    {
        return $this->belongsTo(Usuario::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Usuario::class, 'receiver_id');
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
