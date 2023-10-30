<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Welcome extends Component
{
    public function __construct(
        public array $notifications = []
    ){}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.welcome');
    }
}
