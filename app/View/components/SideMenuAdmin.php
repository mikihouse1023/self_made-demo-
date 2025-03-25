<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SideMenuAdmin extends Component
{

    public $side_menus;
    /**
     * Create a new component instance.
     */
    public function __construct($side_menus)
    {
        //
        $this->side_menus = $side_menus;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.side-menu-admin');
    }
}
