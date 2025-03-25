<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SetMealAdmin extends Component
{

    public $set_meals;
    /**
     * Create a new component instance.
     */
    public function __construct($set_meals)
    {
        $this->set_meals = collect($set_meals);
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.set-meal-admin');
    }
}
