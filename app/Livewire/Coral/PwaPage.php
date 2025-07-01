<?php

namespace App\Livewire\Coral;

use App\Enums\OrderStatus;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PwaPage extends Component
{
    public $categories;
    public $settings;
    public $productsByCategory = [];
    public $productID;
    public $favoritesCount = 0;
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
        $this->loadFavoritesCount();
    }

    public function loadFavoritesCount()
    {
        $user = auth()->user();

        if ($user) {
            $this->favoritesCount = $user->favorites()->count();
        } else {
            $this->favoritesCount = 0;
        }
    }

    protected $listeners = [
        'favorite-updated' => 'loadFavoritesCount',
        'finalize-order' => 'finalizeOrder',
    ];


    #[On('finalize-order')]
    public function finalizeOrder(array $items)
    {
        // اعتبارسنجی
        $validator = Validator::make(
            ['items' => $items],
            [
                'items' => ['required', 'array', 'min:1'],
                'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
                'items.*.quantity' => ['required', 'integer', 'min:1'],
            ]
        );

        if ($validator->fails()) {
            $this->addError('cart', 'برخی اطلاعات سبد خرید معتبر نیستند.');
            return;
        }

        $validated = $validator->validated()['items'];

        // محاسبه مجموع سفارش
        $total = 0;
        foreach ($validated as $item) {
            $product = Product::find($item['product_id']);
            $total += $product->price * $item['quantity'];
        }

        // شروع تراکنش
        DB::beginTransaction();

        try {
            // ساخت سفارش جدید
            $order = Order::create([
                'user_id' => Auth::id(),
                'table_id' => !session()->has('tableId') ? session()->put('tableId', 1) : '1',
                'total' => $total,
                'status' => OrderStatus::PENDING,
            ]);

            // ساخت orderLines
            foreach ($validated as $item) {
                $order->orderLines()->create([
                    'product_id' => $item['product_id'],
                    'qty' => $item['quantity'],
                    'price' => Product::find($item['product_id'])->price,
                ]);
            }

            DB::commit();

            session()->flash('success', 'سفارش با موفقیت ثبت شد.');
            $this->dispatch('order-finalized');

        } catch (\Exception $e) {
            DB::rollBack();
            info($e->getMessage());
            $this->addError('cart', 'خطا در ثبت سفارش. لطفا دوباره تلاش کنید.');
        }
    }

    public function render()
    {
        return view('livewire.coral.pwa-page')->layout('components.layouts.pwa');
    }
}

