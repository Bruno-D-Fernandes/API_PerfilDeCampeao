<?php

namespace App\View\Components;

use Illuminate\View\Component;

class IconButton extends Component
{
    public $color;

    public function __construct(string $color = 'gray')
    {
        $this->color = $color;
    }

    public function colorClasses(): string
    {
        return match($this->color) {
            'gray' => 'text-gray-600 hover:text-gray-700 focus:ring-gray-500',
            'blue' => 'text-blue-600 hover:text-blue-700 focus:ring-blue-500',
            'red' => 'text-red-600 hover:text-red-700 focus:ring-red-500',
            'green' => 'text-green-600 hover:text-green-700 focus:ring-green-500',
            'yellow' => 'text-yellow-600 hover:text-yellow-700 focus:ring-yellow-500',
            'purple' => 'text-purple-600 hover:text-purple-700 focus:ring-purple-500',
            default => 'text-gray-600 hover:text-gray-700 focus:ring-gray-500',
        };
    }

    public function render()
    {
        return view('components.icon-button');
    }
}

