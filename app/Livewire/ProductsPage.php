<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class ProductsPage extends Component
{
    public $title;
    public $categoryName;
    public $categoryId;

    public function mount(Category $category)
    {
        $this->categoryName = $category->name;
        $this->categoryId = $category->id;
        $this->title = config('app.name') ." :: ". $category->name;
    }

    public function render()
    {
        return view('livewire.products-page')
            ->title($this->title);
    }
}
