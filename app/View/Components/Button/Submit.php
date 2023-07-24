<?php

namespace App\View\Components\Button;

use Illuminate\View\Component;

class Submit extends Component
{
    public $target;
    public $text;
    public $loading;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($target, $text, $loading)
    {
        $this->loading = $loading;
        $this->target = $target;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button.submit');
    }
}
