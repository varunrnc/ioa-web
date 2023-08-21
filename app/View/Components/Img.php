<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Img extends Component
{
    public $src, $id, $name, $btnid;

    /**
     * Create a new component instance.
     */
    public function __construct($src, $id, $name, $btnid)
    {
        $this->src = $src;
        $this->id = $id;
        $this->name = $name;
        $this->btnid = $btnid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.img');
    }
}
