<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class SearchInput extends Component
{
    public $search = '';

    public $products = null;

    public function updatedSearch()
    {      
        $this->products = Product::where('name', 'like', '%'.$this->search.'%')->get();
        if(strlen($this->search) < 3) {
            $this->products = null;
        }
    }

    public function render()
    {
        return view('livewire.search-input');
    }
}
