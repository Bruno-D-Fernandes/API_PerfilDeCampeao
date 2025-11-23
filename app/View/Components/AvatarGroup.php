<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AvatarGroup extends Component
{
    public $items;
    public $max;
    public $size;

    public function __construct($items, $max = 3, $size = 'md')
    {
        $this->items = $items;
        $this->max = $max;
        $this->size = $size;
    }

    public function render()
    {
        return view('components.avatar-group');
    }
}