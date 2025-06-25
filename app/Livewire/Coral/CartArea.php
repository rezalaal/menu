<?php

namespace App\Livewire\Coral;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartArea extends Component
{

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
        return view('livewire.coral.cart-area');
    }
}
