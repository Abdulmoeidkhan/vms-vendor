<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    /**
     * Create a new component instance.
     */
    public $badgeData;
    public $componentKey;
    public function __construct(
        $componentKey,
        $badgeData
    ) {
        $this->componentKey = $componentKey;
        $this->badgeData = $badgeData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.badge');
    }
}
