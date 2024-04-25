<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductView extends Component
{
    public $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.product-view');
    }
}
