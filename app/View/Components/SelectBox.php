<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectBox extends Component
{
    public array $options; // ←追加

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $options) // ←追加
    {
        $this->options = $options; // ←追加
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-box');
    }

    
}
