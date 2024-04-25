<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class ProductList extends Component
{
    public $products;

    public function mount(Category $category)
    {
        $this->products = $category->products;
    }

    public function render()
    {
        return view('livewire.product-list');
    }
}
