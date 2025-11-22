<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormCard extends Component
{
    public $title;
    public $description;
    public $color;

    public function __construct($title, $description, $color = 'gray')
    {
        $this->title = $title;
        $this->description = $description;
        $this->color = $color;
    }

    public function render()
    {
        return view('components.form-card');
    }
}
