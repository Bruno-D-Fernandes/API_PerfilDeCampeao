<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConversationItem extends Component
{
    public $chat;

    public function __construct($chat)
    {
        $this->chat = $chat;
    }

    public function render()
    {
        return view('components.conversation-item');
    }
}
