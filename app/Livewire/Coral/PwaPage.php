<?php

namespace App\Livewire\Coral;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Settings\GeneralSettings;
use Livewire\Component;

class PwaPage extends Component
{
    public $categories;
    public $settings;
    public $products;

    public function mount(GeneralSettings $generalSettings)
    {
        $categories = Category::with('products')->orderBy('sort_order')->get();
        $this->categories = CategoryResource::collection($categories)->resolve();
        $this->settings = $generalSettings->toArray();
        $products = Product::orderBy('category_id')->get();
        $this->products = ProductResource::collection($products)->resolve();
    }

    public function render()
    {
        return view('livewire.coral.pwa-page')->layout('components.layouts.pwa');
    }
}
