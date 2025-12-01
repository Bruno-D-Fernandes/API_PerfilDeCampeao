<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public $color;
    public $dismissable;
    public $border;

    public function __construct($color = 'gray', $dismissable = false, $border = true)
    {
        $this->color = $color;
        $this->dismissable = $dismissable;
        $this->border = $border;
    }

    public function render()
    {
        return view('components.badge');
    }
}
