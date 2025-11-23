<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Progress extends Component
{
    public $percentage;
    public $label;
    public $color;
    public $showValue;

    public function __construct($percentage, $label = null, $color = 'green', $showValue = true)
    {
        $this->percentage = min(100, max(0, $percentage));
        $this->label = $label;
        $this->color = $color;
        $this->showValue = $showValue;
    }

    public function render()
    {
        return view('components.progress');
    }
}