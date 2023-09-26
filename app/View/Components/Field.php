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
    public $columnName;
    public $column;
    public function __construct($type, $isRequired, $columnName, $column)
    {
        $this->type = $type;
        $this->isRequired = $isRequired;
        $this->columnName = $columnName;
        $this->column = $column;
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