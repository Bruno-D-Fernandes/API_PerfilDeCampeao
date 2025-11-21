<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarSection extends Component
{
    public $title;

    public function __construct(string $title = '')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.sidebar-section');
    }
}