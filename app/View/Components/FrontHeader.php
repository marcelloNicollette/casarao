<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class FrontHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public $currentUser;

    public function __construct()
    {

        $this->currentUser = Auth::user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.front.header', ['user' => $this->currentUser]);
    }
}
