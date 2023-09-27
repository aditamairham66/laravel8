<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Field extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $type;
    public $isRequired;
    public $label;
    public $column;
    public $value;
    public function __construct($type, $isRequired, $label, $column = null, $value = null)
    {
        $this->type = $type;
        $this->isRequired = $isRequired;
        $this->label = $label;
        $this->column = $column;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.field');
    }
}
