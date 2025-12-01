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
        
        if ($this->href) {
            $path = parse_url($href, PHP_URL_PATH);
            $pattern = trim($path ?? '', '/') . '*';

            $this->active = $active ?: (request()->fullUrl() == $href || request()->is($pattern));
        } else {
            $this->active = $active;
        }

        $styles = match($context) {
            'admin' => [
                'bg' => 'bg-sky-500',
                'hover' => 'hover:bg-sky-500',
            ],
            'logout' => [
                'bg' => 'bg-red-500',
                'hover' => 'hover:bg-red-500'
            ],
            default => [
                'bg' => 'bg-emerald-500',
                'hover' => 'hover:bg-emerald-500',
            ],
        };

        $this->activeClass = "{$styles['bg']} text-white";

        $this->inactiveClass = "text-inative {$styles['hover']} hover:text-white";
    }

    public function render()
    {
        return view('components.sidebar-link');
    }
}