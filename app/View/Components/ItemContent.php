<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ItemContent extends Component
{
    public $id;
    public $product;
    public $image;
    public $color;
    public $size;
    public $grid;

    /**
     * Create a new component instance.
     */
    public function __construct($id, $product, $image, $color, $size, $grid)
    {
        $this->id = $id;
        $this->product = $product;
        $this->image = $image;
        $this->color = $color;
        $this->size = $size;
        $this->grid = $grid;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.front.item-content');
    }
}
