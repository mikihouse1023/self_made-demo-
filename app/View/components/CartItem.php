<?php
namespace App\View\Components;

use Illuminate\View\Component;

class CartItem extends Component
{
    public $item;
    public $delete;

    /**
     * Create a new component instance.
     */
    public function __construct($item, $delete = false)
    {
        $this->item = $item;
        $this->delete = $delete;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.cart-item');
    }
}


