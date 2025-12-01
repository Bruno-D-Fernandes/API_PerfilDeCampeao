<?php

namespace App\View\Components;

use Illuminate\View\Component;

class OpportunityItem extends Component
{
    public $opportunity;
    public $hasActions;

    public function __construct($opportunity, $hasActions = false)
    {
        $this->opportunity = $opportunity->load('inscricoes.usuario');
        $this->hasActions = $hasActions;
    }

    public function statusColor()
    {
        return match($this->opportunity->status) {
            'approved'  => ['color' => 'green', 'text' => 'Aprovada'],
            'rejected' => ['color' => 'red', 'text' => 'Rejeitada'],
            default   => ['color' => 'gray', 'text' => 'Pendente'],
        };
    }

    public function progress()
    {
        $limit = $this->opportunity->limite_inscricoes ?? 10;
        $current = $this->opportunity->inscricoes->count();

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