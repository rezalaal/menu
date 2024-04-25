<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderLine;
use Livewire\Component;

class OrderView extends Component
{
    public $order;

    public function mount(Order $order)
    {               
        if($order->user_id !== auth()->user()?->id){            
            $this->order = null;
        }
        $this->order = $order;
    }

    public function render()
    {
        return view('livewire.order-view');
    }
}
