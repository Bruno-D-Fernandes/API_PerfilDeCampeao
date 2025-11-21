<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Form extends Component
{
    public $title;

    public function __construct($title = 'Formulário')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.layouts.form');
    }
}