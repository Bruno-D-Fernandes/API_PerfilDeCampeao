<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MessageInput extends Component
{
    public $name;
    public $placeholder;
    public $value;

    public function __construct($name = 'message', $placeholder = 'Digite sua mensagem...', $value = null)
    {
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.message-input');
    }
}