<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public $color;
    public $dismissable;
    public $text;

    public function __construct($color = 'gray', $dismissable = false)
    {
        $this->color = $color;
        $this->dismissable = $dismissable;
    }

    public function render()
    {
        return view('components.badge');
    }
}
