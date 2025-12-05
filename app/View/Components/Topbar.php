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
    public $context;

    public function __construct($title, $breadcrumb = [], $context = 'clube')
    {
        $this->title = $title;
        $this->breadcrumb = $breadcrumb;
        $this->context = $context;
        
        if ($context === 'admin') {
            $this->user  = Auth::guard('admin')->user();
            $this->type  = $this->user instanceof Admin ? 'Admin' : 'Visitante';
            $this->color = 'sky-500';
        } elseif ($context === 'clube') {
            $this->user  = Auth::guard('club')->user();
            $this->type  = $this->user instanceof Clube ? 'Clube' : 'Visitante';
            $this->color = 'emerald-500';
        } else {
            $this->user  = null;
            $this->type  = 'Visitante';
            $this->color = 'emerald-500';
        }
    }

    public function render()
    {
        return view('components.topbar');
    }
}