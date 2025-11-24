<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RangeSlider extends Component
{
    public $label;
    public $nameMin;
    public $nameMax;
    public $min;
    public $max;
    public $step;
    public $unit;
    public $id;
    public $color;

    public function __construct(
        $label, 
        $nameMin, 
        $nameMax, 
        $min = 0, 
        $max = 100, 
        $step = 1, 
        $unit = '',
        $color = 'green'
    )
    {
        $this->label = $label;
        $this->nameMin = $nameMin;
        $this->nameMax = $nameMax;
        $this->min = $min;
        $this->max = $max;
        $this->step = $step;
        $this->unit = $unit;
        $this->id = 'range_' . uniqid();
        $this->color = $color;
    }

    public function render()
    {
        return view('components.range-slider');
    }
}