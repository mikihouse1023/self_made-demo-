<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DishAdmin extends Component
{

    public $dishes;
    /**
     * Create a new component instance.
     */
    public function __construct($dishes)
    {
        //
        $this->dishes = $dishes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dish-admin');
    }
}
