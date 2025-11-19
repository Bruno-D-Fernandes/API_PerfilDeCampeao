<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;

class Admin extends Component
{
    public $title;
    public $breadcrumb;

    public function __construct($title, $breadcrumb = [])
    {
        $this->title = $title;
        $this->breadcrumb = $breadcrumb;
    }

    public function render()
    {
        return view('components.layouts.admin');
    }
}