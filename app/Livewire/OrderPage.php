<?php

namespace App\Livewire;

use Livewire\Component;

class OrderPage extends Component
{
    public $tab = "current";


    public function switch($tab)
    {
        if($tab == "curr"){
            $this->tab = "current";
        }
        if($tab == "prev") {
            $this->tab = "previous";
        }
    }

    public function render()
    {
        return view('livewire.order-page');
    }
}
