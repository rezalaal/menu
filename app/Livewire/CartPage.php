<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Table;
use Livewire\Component;
use App\Models\CartItem;
use App\Models\OrderLine;
use Illuminate\View\View;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class CartPage extends Component
{
    public Collection|null $cartItems = null;
    public CartItem $item;
    public string $title;
    public string|null $table;

    public function mount():void
    {
        $user = auth()->user();
        if($user) {
            $this->cartItems = CartItem::with('product')
                ->where('cart_id', $user->cart->id)
                ->get();
        }
        $this->table = Table::where('id', session()->get('tableId'))->first()?->name;
        $this->title = config('app.name') ." :: سبد خرید";
    }

    public function increase(CartItem $item):void
    {
        $cartItem = CartItem::where([
            'cart_id' => $item->cart->id,
            'product_id' => $item->product->id
        ])->first();

        $qty = $cartItem->qty + 1;

        $cartItem->update([
            'qty' => $qty
        ]);
        $this->cartItems = CartItem::with('product')
                ->where('cart_id', $item->cart->id)
                ->get();

        $this->dispatch('cart-updated');
    }

    public function decrease(CartItem $item):void
    {
        $cartItem = CartItem::where([
            'cart_id' => $item->cart->id,
            'product_id' => $item->product->id
        ])->first();
        $qty = $cartItem->qty - 1;

        $cartItem->update([
            'qty' => $qty
        ]);

        if($qty <= 0 ) {
            $cartItem->delete();
        }
        $this->cartItems = CartItem::with('product')
                ->where('cart_id', $item->cart->id)
                ->get();
        $this->dispatch('cart-updated');
    }
    /**
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function addToBag()
    {
        $tableId = session()->get('tableId');
        if(!$tableId) {
            $tableId = 1;
        }

        $total = $this->cartItems->sum(function($cartItem):mixed {
                return $cartItem->product->price * $cartItem->qty;

        });

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'table_id' => $tableId,
            'total' => $total,
            'status' => OrderStatus::PENDING
        ]);

        foreach($this->cartItems as $cartItem) {
            OrderLine::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product->id,
                'qty' => $cartItem->qty,
                'price' => $cartItem->product->price
            ]);
            $cartItem->delete();
        }

        return redirect()->to('orders');
    }

    public function render(): View
    {
        return view('livewire.cart-page')
            ->title($this->title);
    }
}
