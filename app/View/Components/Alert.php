<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $type = 'success')
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Example to pass $prefix in component view
        return view('components.alert' /*, [
            'prefix' => 'Hello world ! '
        ] */);
    }
}
