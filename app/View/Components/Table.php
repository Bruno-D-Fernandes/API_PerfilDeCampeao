<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $items;
    public $tableId;

    public function __construct($items = null, $tableId = 'default-table')
    {
        $this->items = $items;
        $this->tableId = $tableId;
    }

    public function render()
    {
        return view('components.table');
    }
}