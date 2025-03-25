<?php
// app/View/Components/ReservationListAdmin.php
namespace App\View\Components;

use Illuminate\View\Component;

class ReservationListAdmin extends Component
{
    public $reservations;

    /**
     * コンポーネントのコンストラクタ
     */
    public function __construct($reservations)
    {
        $this->reservations = $reservations;
    }

    /**
     * ビューを返す
     */
    public function render()
    {
        return view('components.reservation-list-admin');
    }
}
