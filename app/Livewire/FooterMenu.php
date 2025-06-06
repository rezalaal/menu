<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Cart;

class FooterMenu extends Component
{
    public int $cartCount = 0;

    protected $listeners = ['cart-updated' => 'updateCartCount'];

    public function mount()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->withCount('cartItems')->first();
            $this->cartCount = $cart?->cart_items_count ?? 0;
        }
    }

    public function updateCartCount()
    {
        $user = auth()->user();
        $this->cartCount = $user?->cart?->cartItems()->count() ?? 0;
    }

    public function render()
    {
        return view('livewire.footer-menu');
    }
}
