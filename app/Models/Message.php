<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'message',
        'type',
        'is_read',
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
}
