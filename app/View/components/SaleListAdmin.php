<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SaleListAdmin extends Component
{
    public $sales;
    /**
     * Create a new component instance.
     */
    public function __construct($sales)
    {
        //
        $this->sales = $sales;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sale-list-admin');
    }
}
