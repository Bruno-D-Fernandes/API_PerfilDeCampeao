<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Tabs extends Component
{
    public $options;
    public $default;

    public function __construct($options, $default)
    {
        $this->options = $options;
        $this->default = $default;
    }

    public function render()
    {
        return view('components.tabs');
    }
}