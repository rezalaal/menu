<?php

namespace App\Livewire\Coral;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrderStatus;

class Checkout extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Order::with('orderLines.product')
            ->where('user_id', Auth::id())
            ->where('status', OrderStatus::PENDING)
            ->latest()
            ->get();
    }

    public function postPay($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            $this->addError('order', 'سفارش یافت نشد یا دسترسی ندارید.');
            return;
        }

        $order->status = OrderStatus::WAITING_FOR_CONFIRMATION;
        $order->save();

        session()->flash('success', 'وضعیت سفارش با موفقیت به «در انتظار تایید» تغییر کرد.');

        return redirect()->to('orders');
    }


    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->where('status', OrderStatus::PENDING)
            ->first();

        if (! $order) {
            $this->addError('order', 'سفارشی با این مشخصات یافت نشد یا مجاز به انصراف نیستید.');
            return;
        }

        $order->update(['status' => OrderStatus::CANCELED]);

        // حذف سفارش از لیست موجود در کامپوننت
        $this->orders = $this->orders->filter(fn($o) => $o->id !== $order->id);

        session()->flash('success', 'سفارش با موفقیت لغو شد.');
    }



    public function render()
    {
        return view('livewire.coral.checkout')->layout('components.layouts.pwa');
    }
}
