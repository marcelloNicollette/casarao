<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ClearProduct extends Component
{
    public $id;
    public $categories;
    public $title;
    public $images = [];
    public $slug;

    /**
     * Create a new component instance.
     */
    public function __construct($id, $categories, $title, $images = [], $slug)
    {
        $this->id = $id;
        $this->title = $title;
        $this->images = $images;
        $this->categories = $categories;
        $this->slug = $slug;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.front.clear-product');
    }
}
