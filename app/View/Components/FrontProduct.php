<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontProduct extends Component
{
    public $id;
    public $categories;
    public $title;
    public $images = [];
    public $description;
    public $slug;
    public $price;
    public $unidade;

    /**
     * Create a new component instance.
     */
    public function __construct($id, $title, $images = [], $description, $slug, $price, $unidade)
    {
        $this->id = $id;
        $this->title = $title;
        $this->images = $images;
        $this->description = $description;
        $this->slug = $slug;
        $this->price = $price;
        $this->unidade = $unidade;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.front.product');
    }
}
