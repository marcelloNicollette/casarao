<?php

namespace App\View\Components;

use App\Models\SegmentacaoPreco;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class FrontSubHeader extends Component
{
    public $segmentacao;
    /**
     * Create a new component instance.
     */
    public function __construct() {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        //dd($segmentacao);
        return view('components.front.sub-header');
    }
}
