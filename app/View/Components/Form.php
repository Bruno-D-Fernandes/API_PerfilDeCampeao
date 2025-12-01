<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Form extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('components.form');
    }
}