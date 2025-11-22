<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public $color;
    public $label;

    public function __construct($color = 'gray', $label = null)
    {
        $this->color = $color;
        $this->label = $label;
    }

    public function render()
    {
        return view('components.checkbox');
    }
}
