<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardsInicio extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $color,public string $icono,public string $titulo,public string $cantidad)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards-inicio');
    }
}
