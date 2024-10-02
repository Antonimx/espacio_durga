<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalBorrado extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $url,public string $id,public string $textoBoton,public string $textoTitulo)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-borrado');
    }
}
