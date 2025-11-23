<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableHeader extends Component
{
    public $label;
    public $name;
    public $sortable;

    public function __construct($label, $name = null, $sortable = false)
    {
        $this->label = $label;
        $this->name = $name;
        $this->sortable = $sortable;
    }

    public function render()
    {
        return view('components.table-header');
    }
}