<?php

namespace App\Livewire;

use Livewire\Component;

class CategoryPage extends Component
{
    public $title;

    public function mount()
    {
        $this->title = config('app.name') . " منو ";
    }

    public function render()
    {
        return view('livewire.category-page')->title($this->title);
    }
}
