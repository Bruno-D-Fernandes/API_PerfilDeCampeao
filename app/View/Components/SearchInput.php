<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchInput extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('components.search-input');
    }
}