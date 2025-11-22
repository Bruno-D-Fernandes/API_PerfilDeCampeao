<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormGroup extends Component
{
    public $label;
    public $name;
    public $type;
    public $id;
    public $labelColor;

    public function __construct($label, $name, $type = 'text', $id = null, $labelColor = 'gray')
    {
        $this->label = $label;
        $this->name = $name;
        $this->type = $type;
        $this->id = $id ?? $name;
        $this->labelColor = $labelColor;
    }

    public function render()
    {
        return view('components.form-group');
    }
}