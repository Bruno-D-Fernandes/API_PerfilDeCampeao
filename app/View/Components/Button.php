<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $color;
    public $size;
    public $type;
    public $full;

    public function __construct($color = 'gray', $size = 'md', $type = 'button', $full = false) 
    {
        $this->color = $color;
        $this->size = $size;
        $this->type = $type;
        $this->full = $full;
    }

    public function render()
    {
        return view('components.button');
    }
}
