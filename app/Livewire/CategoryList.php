<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryList extends Component
{
    public $categories;
    public $title;

    public function mount() 
    {
        $this->categories = Category::all();
        $this->title = "منو :: ". config('app.name');
    }

    public function render()
    {
        return view('livewire.category-list')
            ->title($this->title);
    }
}
