<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $class;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class="alert-success")
    {
        $this->class = $class;
    }

    public function removeBtn(){
        if ($this->class === "alert-danger"){
            return true;
        }
    }
    public function showDateTime(){
        $d = date("Y-M-d");
        $t = date("H:m a");

        return $d." ".$t;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
