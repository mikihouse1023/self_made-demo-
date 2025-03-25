<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewsAdmin extends Component
{
    public $news;
    /**
     * Create a new component instance.
     */
    public function __construct($news)
    {
        //
        $this->news = $news;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.news-admin');
    }
}
