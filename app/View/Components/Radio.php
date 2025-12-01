<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Radio extends Component
{
    public $label;
    public $name;
    public $value;
    public $id;
    public $color;

    public function __construct($name, $label = null, $value = '', $id, $color = 'gray')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->color = $color;
        $this->id = $id;
    }

    public function render()
    {
        return view('components.radio');
    }
}