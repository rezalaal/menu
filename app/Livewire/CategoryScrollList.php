<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategoryScrollList extends Component
{
    public $categories;
    public $categoryId;

    public function mount($categoryId)
    {        
        $this->categories = Category::orderBy('sort_order')->get();
    }

    public function category($id)
    {
        return redirect()->to("/products/". $id);
    }

    public function render()
    {
        return view('livewire.category-scroll-list');
    }
}
