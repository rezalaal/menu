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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class PwaPage extends Component
{
    public $categories = [];
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

    public function mount(GeneralSettings $generalSettings)
    {
        $this->settings = Cache::remember('general_settings', now()->addYear(), function () use ($generalSettings) {
            return $generalSettings->toArray();
        });
    }

    public function loadData()
    {
        $start = microtime(true);

        $categories = Cache::remember('categories_with_count', now()->addMonths(2), function () {
            return Category::select('id', 'name', 'sort_order')
                ->orderBy('sort_order')
                ->get();
        });

        $this->categories = CategoryResource::collection($categories)->resolve();

        $this->loadProducts();

        $duration = round((microtime(true) - $start) * 1000, 2);
        Log::info('📦 loadData done', [
            'duration_ms' => $duration,
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
        ]);
    }

    public function loadProducts()
    {
        $start = microtime(true);

        $categories = Category::select('id', 'name')->get();
        $byCat = [];

        foreach ($categories as $cat) {
            $products = Cache::remember("category_products_{$cat->id}", now()->addMonths(2), function () use ($cat) {
                return Product::where('category_id', $cat->id)->get();
            });


            // در صورت نبود محصول، از افزودن دسته صرف‌نظر می‌کنیم
            if ($products->isEmpty()) {
                continue;
            }

            $byCat[$cat->id]['category'] = [
                'id' => $cat->id,
                'name' => $cat->name,
                'image_url' => $cat->getFirstMediaUrl('image') ?: asset('images/placeholder.png'),
            ];

            $byCat[$cat->id]['products'] = ProductResource::collection($products)->resolve();
        }

        $this->productsByCategory = array_values($byCat);

        $duration = round((microtime(true) - $start) * 1000, 2);
        Log::info('🛍 loadProducts done', [
            'duration_ms' => $duration,
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
        ]);
    }

    #[On('finalize-order')]
    public function finalizeOrder(array $items)
    {
        $this->dispatch('order-finalizing');

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
        $total = 0;

        foreach ($validated as $item) {
            $product = Product::find($item['product_id']);
            $total += $product->price * $item['quantity'];
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'table_id' => session()->get('tableId', 1),
                'total' => $total,
                'status' => OrderStatus::PENDING,
            ]);

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

    protected $listeners = [
        'finalize-order' => 'finalizeOrder',
    ];

    public function render(): View
    {
        return view('livewire.coral.pwa-page')->layout('components.layouts.pwa');
    }
}
