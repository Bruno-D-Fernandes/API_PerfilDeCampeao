<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $name;
    public $title;
    public $maxWidth;
    public $titleSize;
    public $titleColor;

    public function __construct($name, $title = null, $maxWidth = '2xl', $titleSize = 'xl', $titleColor = 'green')
    {
        $this->name = $name;
        $this->title = $title;
        $this->maxWidth = $maxWidth;
        $this->titleSize = $titleSize;
        $this->titleColor = $titleColor;
    }

    public function render()
    {
        return view('components.modal');
    }
}