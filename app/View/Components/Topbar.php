<?php

namespace App\View\Components;

use App\Models\Clube;
use App\Models\Admin;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Topbar extends Component
{
    public $title;
    public $breadcrumb;
    public $user;
    public $type;
    
    public $color; 

    public function __construct($title, $breadcrumb = [], $context)
    {
        $this->title = $title;
        $this->breadcrumb = $breadcrumb;
        
        $this->user = Auth::user() ?? (object) [
            'name' => 'Visitante', 
            'email' => 'guest@sistema.com'
        ];

        $this->type = ($this->user instanceof Clube ? 'Clube' : ($this->user instanceof Admin ? 'Admin' : 'Visitante'));

        $this->color = $context == 'admin' ? 'sky-500' : 'emerald-500';
    }

    public function render()
    {
        return view('components.topbar');
    }
}