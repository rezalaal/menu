<div class="px-4 space-y-3">
    <span wire:loading class="text-coral-from/60 text-xs font-iransans-thin block animate-pulse">در حال بارگذاری...</span>

    @foreach($orders as $order)
        <div wire:click="order({{$order->id}})" class="card-coral p-4 cursor-pointer hover:scale-[1.01] active:scale-[0.99] transition-all duration-300 animate-fade-in-up">
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="font-iransans-thin text-coral-from/60">تاریخ</span>
                    <span class="font-iransans-thin text-coral-from farsi-number">{{ verta($order->created_at)->format("Y/m/d") }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-iransans-thin text-coral-from/60">ساعت</span>
                    <span class="font-iransans-thin text-coral-from farsi-number">{{ verta($order->created_at)->format("H:i") }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-iransans-thin text-coral-from/60">مبلغ</span>
                    <span class="font-iransans-bold text-coral-from farsi-number">{{ number_format($order->total) }} تومان</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-iransans-thin text-coral-from/60">وضعیت</span>
                    <span class="px-2 py-0.5 rounded-full bg-coral/20 text-coral-from text-xs font-iransans-bold">{{ $order->status }}</span>
                </div>
                <div class="flex items-center justify-between col-span-2">
                    <span class="font-iransans-thin text-coral-from/60">میز</span>
                    <span class="font-iransans-thin text-coral-from">{{ $order->table->name }}</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
