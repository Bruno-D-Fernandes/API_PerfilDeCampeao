<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarLink extends Component
{
    public $href;
    public $active;
    public $label;

    public $activeClass;
    public $inactiveClass;

    public function __construct($href, $context = 'clube', $label = null, $active = false)
    {
        $this->href = $href;
        $this->label = $label;
        
        $this->active = $active ?: (request()->fullUrl() == $href || request()->is(trim(parse_url($href, PHP_URL_PATH), '/') . '*'));

        $styles = match($context) {
            'admin' => [
                'bg' => 'bg-adm-primary',
                'hover' => 'hover:bg-adm-primary',
            ],
            'clube' => [
                'bg' => 'bg-primary',
                'hover' => 'hover:bg-primary',
            ],
            default => [
                'bg' => 'bg-primary',
                'hover' => 'hover:bg-primary',
            ]
        };

        $this->activeClass = "{$styles['bg']} text-white";

        $this->inactiveClass = "text-inative {$styles['hover']} hover:text-white";
    }

    public function render()
    {
        return view('components.sidebar-link');
    }
}