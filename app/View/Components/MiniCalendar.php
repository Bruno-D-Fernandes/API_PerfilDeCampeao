<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class MiniCalendar extends Component
{
    public $date;
    public $highlight;
    
    public $daysInMonth;
    public $startDayOfWeek;

    public function __construct($month = null, $year = null, $selected = null)
    {
        $m = $month ?? now()->month;
        $y = $year ?? now()->year;

        $this->date = Carbon::createFromDate($y, $m, 1);
        
        $this->highlight = $selected ? Carbon::parse($selected) : Carbon::today();

        $this->daysInMonth = $this->date->daysInMonth;
        $this->startDayOfWeek = $this->date->dayOfWeek; 
    }

    public function isSelected($day)
    {
        if (!$this->highlight) return false;

        return $this->highlight->year === $this->date->year &&
               $this->highlight->month === $this->date->month &&
               $this->highlight->day === $day;
    }

    public function render()
    {
        return view('components.mini-calendar');
    }
}