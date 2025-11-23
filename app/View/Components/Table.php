<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $items;

    public function __construct($items = null)
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('components.table');
    }
}