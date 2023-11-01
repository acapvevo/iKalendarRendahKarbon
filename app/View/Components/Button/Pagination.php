<?php

namespace App\View\Components\Button;

use Illuminate\View\Component;

class Pagination extends Component
{
    public $target;
    public $text;
    public $type;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($target, $text, $type)
    {
        $this->type = $type;
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
        return view('components.button.pagination');
    }
}
