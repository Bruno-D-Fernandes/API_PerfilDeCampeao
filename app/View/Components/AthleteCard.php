<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AthleteCard extends Component
{
    public $athlete;

    public function __construct($athlete)
    {
        $this->athlete = $athlete;
    }

    public function render()
    {
        return view('components.athlete-card');
    }
}