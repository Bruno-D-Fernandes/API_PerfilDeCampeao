<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Avatar extends Component
{
    public $src;
    public $alt;
    public $size;

    public function __construct($src = null, $alt = '', $size = 'md')
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->size = $size;
    }

    public function render()
    {
        return view('components.avatar');
    }
}