<?php

namespace App\Livewire\Coral;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Settings\GeneralSettings;
use Illuminate\View\View;
use Livewire\Component;

class PwaPage extends Component
{
    public $categories;
    public $settings;
    public $productsByCategory = [];

    public function placeholder(): View
    {
        return view('placeholder');
    }
    public function mount(GeneralSettings $generalSettings)
    {
        $categories = Category::with('products')->orderBy('sort_order')->get();
        $this->categories = CategoryResource::collection($categories)->resolve();

        $this->settings = $generalSettings->toArray();

        // گروه‌بندی محصولات بر اساس دسته
        $products = Product::with('media')->orderBy('category_id')->get();
        $byCat = [];
        foreach ($products as $prod) {
            $byCat[$prod->category->id]['category'] = [
                'id' => $prod->category->id,
                'name' => $prod->category->name,
            ];
            $byCat[$prod->category->id]['products'][] = ProductResource::make($prod)->resolve();
        }
        $this->productsByCategory = array_values($byCat);
    }

    public function render()
    {
        return view('livewire.coral.pwa-page')->layout('components.layouts.pwa');
    }
}

