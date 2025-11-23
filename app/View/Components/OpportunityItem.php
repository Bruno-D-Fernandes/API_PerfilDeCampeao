<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OpportunityItem extends Component
{
    public $opportunity;

    public function __construct($opportunity)
    {
        $this->opportunity = $opportunity;
    }

    public function statusColor()
    {
        return match($this->opportunity->status) {
            'ativa'  => ['color' => 'green', 'text' => 'Ativa'],
            'rejeitada' => ['color' => 'red', 'text' => 'Rejeitada'],
            default   => ['color' => 'gray', 'text' => 'Pendente'],
        };
    }

    public function progress()
    {
        $limit = $this->opportunity->vagas ?? 0;
        $current = $this->opportunity->inscritos;

        if ($limit <= 0) return null;

        return [
            'percentage' => min(100, ($current / $limit) * 100),
            'is_full' => $current >= $limit,
            'limit' => $limit
        ];
    }

    public function render()
    {
        return view('components.opportunity-item');
    }
}