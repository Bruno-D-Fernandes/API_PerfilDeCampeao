<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EventBubble extends Component
{
    public $event;
    public $isMe;

    public function __construct($event, $isMe = false)
    {
        $this->event = $event;
        $this->isMe = $isMe;
    }

    public function render()
    {
        return view('components.event-bubble');
    }
}