<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $name;
    public $title;
    public $maxWidth;

    public function __construct($name, $title = null, $maxWidth = '2xl')
    {
        $this->name = $name;
        $this->title = $title;
        $this->maxWidth = $maxWidth;
    }

    public function render()
    {
        return view('components.modal');
    }
}