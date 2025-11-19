<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Base extends Component
{
    public string $title;

    public function __construct(string $title = 'Sistema')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.layouts.base');
    }
}