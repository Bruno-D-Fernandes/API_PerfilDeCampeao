<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Gallery extends Component
{
    public $items;
    public $cols;
    public $rows;

    public function __construct($items, $cols = -1, $rows = -1)
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('components.gallery');
    }
}
