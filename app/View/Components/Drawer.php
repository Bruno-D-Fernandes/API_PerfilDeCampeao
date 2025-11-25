<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class Drawer extends Component
{
    public $id;
    public $width;

    public function __construct($id, $width = 'max-w-md')
    {
        $this->id = $id;
        $this->width = $width;
    }

    public function render()
    {
        return view('components.drawer');
    }
}