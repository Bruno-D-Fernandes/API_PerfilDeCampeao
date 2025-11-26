<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MessageItem extends Component
{
    public $message;
    public $isMe;

    public function __construct($message, $isMe = false)
    {
        $this->message = $message;
        $this->isMe = $isMe;
    }

    public function render()
    {
        return view('components.message-item');
    }
}