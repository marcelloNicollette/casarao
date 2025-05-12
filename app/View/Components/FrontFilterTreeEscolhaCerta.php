<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontFilterTreeEscolhaCerta extends Component
{
    public $familia, $categorias;
    /**
     * Create a new component instance.
     */
    public function __construct($familia, $categorias)
    {
        $this->familia = $familia;
        $this->categorias = $categorias;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.front.filter-tree-escolha-certa');
    }
}
