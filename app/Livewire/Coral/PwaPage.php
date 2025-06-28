<?php

namespace App\Livewire\Coral;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Settings\GeneralSettings;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PwaPage extends Component
{
    public $categories;
    public $settings;
    public $productsByCategory = [];
    public $productID;

    protected $rules = [
        'productID' => 'required|numeric|exists:products,id',
    ];

    protected $messages = [
        'productID.required' => 'کد محصول الزامی است',
        'productID.numeric' => 'کد تایید عددی است',
        'productID.exists' => 'محصول مورد نظر یافت نشد',
    ];

    public function loadProducts()
    {
        $productsQuery = Product::with('media')
            ->orderBy('category_id');

        $user = auth()->user();

        if ($user) {
            $productsQuery->withExists(['favoredBy as is_favorite' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }]);
        } else {
            $productsQuery->selectRaw('*, false as is_favorite');
        }

        $products = $productsQuery->get();

        $byCat = [];

        foreach ($products as $prod) {
            $byCat[$prod->category->id]['category'] = [
                'id' => $prod->category->id,
                'name' => $prod->category->name,
            ];

            $prodResource = ProductResource::make($prod)->resolve();

            $prodResource['is_favorite'] = (bool) $prod->is_favorite;

            $byCat[$prod->category->id]['products'][] = $prodResource;
        }

        $this->productsByCategory = array_values($byCat);
    }

    public function toggleFavorite($productID)
    {
        $this->productID = $productID;
        $this->validate();

        $user = auth()->user();
        if (! $user) {
            $this->addError('auth', 'برای افزودن به علاقه‌مندی‌ها باید وارد حساب کاربری شوید.');
            return;
        }

        if ($user->favorites()->where('product_id', $productID)->exists()) {
            $user->favorites()->detach($productID);
        } else {
            $user->favorites()->attach($productID);
        }

        // بارگذاری مجدد محصولات
        $this->loadProducts();
        $this->dispatch('favorite-updated');
    }



    public function mount(GeneralSettings $generalSettings)
    {
        $categories = Category::with('products')->orderBy('sort_order')->get();
        $this->categories = CategoryResource::collection($categories)->resolve();

        $this->settings = $generalSettings->toArray();

        $this->loadProducts();
    }


    public function render()
    {
        return view('livewire.coral.pwa-page')->layout('components.layouts.pwa');
    }
}

