<?php

namespace App\Livewire;

use App\Enums\OrderStatus;
use App\Models\Order;
use Livewire\Component;

class CurrentOrders extends Component
{
    public $orders;

    public function mount()
    {
        // if(!auth()->user()) {
        //     return abort(404);
        // }
        
        $this->orders = Order::where([            
                'user_id' => auth()->user()?->id
            ])
            ->whereIn('status', [
                OrderStatus::PENDING,
                OrderStatus::PREPARATION,
                OrderStatus::SERVING
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
