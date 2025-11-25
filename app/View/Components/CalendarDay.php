<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CalendarDay extends Component
{
    public $day;
    public $isToday;

    public function __construct($day, $isToday = false)
    {
        $this->day = $day;
        $this->isToday = $isToday;
    }

    public function render()
    {
        return view('components.calendar-day');
    }
}