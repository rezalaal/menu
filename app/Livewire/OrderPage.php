<?php

namespace App\Livewire;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class OrderPage extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::with('orderLines.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    }
    public function render()
    {
        return view('livewire.order-page')->layout('components.layouts.pwa');
    }
}
