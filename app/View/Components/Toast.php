<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Toast extends Component
{
    public $type;
    public $message;
    public $title;
    public $dismissible;

    public function __construct($type = 'info', $message = null, $title = null, $dismissible = true)
    {
        $this->type = $type;
        $this->message = $message;
        $this->title = $title;
        $this->dismissible = $dismissible;
    }

    public function render()
    {
        return view('components.toast');
    }
}