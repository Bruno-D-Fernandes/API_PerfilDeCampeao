<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $items;
    public $tableId;
    public $hasActions;

    public function __construct($items = null, $tableId = 'default-table', $hasActions = false)
    {
        $this->items = $items;
        $this->tableId = $tableId;
        $this->hasActions = $hasActions;
    }

    public function render()
    {
        return view('components.table');
    }
}