<?php
namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Order extends Component
{
    public $orders; 

    /**
     * コンポーネントのインスタンスを作成
     */
    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    /**
     * コンポーネントのビューを返す
     */
    public function render(): View
    {
        return view('components.order');
    }
}
