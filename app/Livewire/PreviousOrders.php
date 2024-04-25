<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Enums\OrderStatus;

class PreviousOrders extends Component
{
    public $orders;
    
    public function mount()
    {
                
        $this->orders = Order::where([            
            'user_id' => auth()->user()?->id
        ])
        ->whereIn('status', [
            OrderStatus::CANCLED,
            OrderStatus::PAID,
        ])
        ->get();
    }

    public function order($id)
    {
        return redirect()->to("/orders/".$id);
    }

    public function render()
    {
        return view('livewire.current-orders');
    }
}
