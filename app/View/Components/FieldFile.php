<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FieldFile extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $isRequired;
    public $label;
    public $column;
    public $columnId;
    public $file;
    public function __construct($isRequired, $label, $column = null, $columnId = null, $file = null)
    {
        $this->isRequired = $isRequired;
        $this->label = $label;
        $this->column = $column;
        $this->columnId = $columnId;
        $this->file = $file;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.field-file');
    }
}
