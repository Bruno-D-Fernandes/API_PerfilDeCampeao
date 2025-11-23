<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Pagination extends Component
{
    public $maxPage;
    public $currentPage;

    public function __construct($maxPage, $currentPage = 1)
    {
        $this->maxPage = $maxPage;
        $this->currentPage = max(1, $currentPage);
    }

    public function pages()
    {
        if ($this->maxPage <= 7) {
            return range(1, $this->maxPage);
        }

        $start = max(2, $this->currentPage - 1);
        $end = min($this->maxPage - 1, $this->currentPage + 1);

        $pages = [1];

        if ($start > 2) {
            $pages[] = '...';
        }

        foreach (range($start, $end) as $page) {
            $pages[] = $page;
        }

        if ($end < $this->maxPage - 1) {
            $pages[] = '...';
        }

        $pages[] = $this->maxPage;

        return $pages;
    }

    public function render()
    {
        return view('components.pagination');
    }
}