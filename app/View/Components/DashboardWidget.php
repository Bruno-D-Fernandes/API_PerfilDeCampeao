<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardWidget extends Component
{
    public $title;
    public $value;
    public $trend;
    public $iconColor;
    public $trendColor;

    public function __construct($title, $value, $trend = null, $iconColor = 'text-emerald-500/70')
    {
        $this->title = $title;
        $this->value = $value;
        $this->trend = $trend;
        $this->iconColor = $iconColor;

        if (is_numeric($trend)) {
            $trendValue = (float) str_replace(['+', '%'], '', $trend);
            $this->trendColor = ($trendValue >= 0) ? 'text-emerald-500' : 'text-red-500';
        } else {
            $this->trendColor = 'text-gray-500';
        }
    }

    public function render()
    {
        return view('components.dashboard-widget');
    }
}