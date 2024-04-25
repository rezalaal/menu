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
        $this->categoryId = $categoryId;
        $this->categories = Category::all();
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
