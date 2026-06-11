<div dir="rtl" class="min-h-screen pb-32">
    <div class="bg-gradient-brand rounded-b-3xl shadow-soft p-6 pt-8">
        <h1 class="font-dastnevis text-2xl text-white text-shadow">
            سفارش <span class="text-sm font-iransans-thin">{{ verta($order->created_at)->format("Y/m/d :: H:i")}}</span>
        </h1>
    </div>

    <div class="px-4 mt-4 space-y-3">
        @foreach ($order->orderLines as $item)
            <div class="card-coral p-3 flex items-center gap-3">
                <a href="/product/{{ $item->product->id }}" class="flex-shrink-0">
                    <img class="w-16 h-16 object-cover rounded-xl shadow-soft"
                         src="{{ $item->product->getFirstMediaUrl() ?: asset('images/placeholder.png') }}"
                         loading="lazy"
                         alt="Product Picture">
                </a>
                <div class="flex-1 min-w-0">
                    <h3 class="font-iransans-thin text-sm text-coral-from truncate">{{ $item->product->name }}</h3>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="font-iransans-thin text-xs text-coral-from/60">تعداد:</span>
                        <span class="farsi-number font-iransans-bold text-xs text-coral-from">{{ $item->qty }}</span>
                    </div>
                    <span class="font-iransans-regular text-xs farsi-number text-coral-from/70">{{ number_format($item->price) }} تومان</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="border-t border-coral/20 mx-4 my-6"></div>

    <div class="card-coral mx-4 p-4 space-y-3">
        <div class="flex items-center justify-between">
            <span class="font-iransans-thin text-coral-from/60">وضعیت</span>
            <span class="font-iransans-bold text-sm text-coral-from">{{ $order->status }}</span>
        </div>
        <div class="flex items-center justify-between">
            <span class="font-iransans-thin text-coral-from/60">جمع کل</span>
            <span class="font-iransans-bold farsi-number text-coral-from">
                {{ number_format($order->total) }} <span class="font-iransans-thin text-xs">تومان</span>
            </span>
        </div>
    </div>

    <livewire:footer-menu />
</div>
