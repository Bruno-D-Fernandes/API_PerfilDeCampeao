<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $id;

    public function __construct($name = null, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function render()
    {
        return view('components.select');
    }
}