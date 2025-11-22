<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Pagination extends Component
{
    public $maxPage;

    public function __construct($maxPage)
    {
        $this->maxPage = $maxPage;
    }

    public function render()
    {
        return view('components.pagination');
    }
}
