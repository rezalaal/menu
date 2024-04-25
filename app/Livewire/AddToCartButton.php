<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\CartItem;
use Illuminate\View\View;

class AddToCartButton extends Component
{
    public Product $product;
    public bool $onCartItems = false;
    public int $qty = 0;
    public User|null $user;
    public bool $loggedIn = true;

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->user = auth()->user();
        if(!$this->user) {
            $this->loggedIn = false;
        }
        $cartItem = CartItem::where([
            'cart_id' => $this->user?->cart?->id,
            'product_id' => $this->product->id
        ])->first();
        
        if($cartItem) {
            $this->onCartItems = true;
            $this->qty = $cartItem->qty;
        }
    }

    /**
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|void
     */
    public function add()
    {
                
        if(!$this->user) {
            return redirect()->to('/table/1');
        }
        
        if(!$this->user->cart) {
            Cart::createNew($this->user);
        }
        
        $cartItem = CartItem::where([
            'cart_id' => $this->user->cart?->id,
            'product_id' => $this->product->id
        ])->first();
        
        if(!$cartItem) {
            $cartItem = CartItem::create([
                'cart_id' => $this->user->cart?->id,
                'product_id' => $this->product->id,
                'qty' => 1
            ]);
        }
        $this->onCartItems = true;
        $this->qty = $cartItem->qty;
    }

    public function increase():void
    {
        $cartItem = CartItem::where([
            'cart_id' => $this->user?->cart?->id,
            'product_id' => $this->product->id
        ])->first();
        $this->qty = $cartItem?->qty + 1;
        $cartItem?->update([
            'qty' => $this->qty
        ]);
        
    }

    public function decrease(): void
    {
        $cartItem = CartItem::where([
            'cart_id' => $this->user?->cart?->id,
            'product_id' => $this->product->id
        ])->first();

        $this->qty = $cartItem?->qty - 1;

        $cartItem?->update([
            'qty' => $this->qty
        ]);

        if($this->qty <= 0 ) {
            $cartItem?->delete();
            $this->onCartItems = false;
        }
    }

    public function render(): View
    {
        return view('livewire.add-to-cart-button');
    }
}
