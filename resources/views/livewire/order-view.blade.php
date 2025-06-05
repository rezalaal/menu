<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to min-h-screen pb-48 flex flex-col">
    <h1 class="font-dastnevis text-3xl font-black mt-10 px-4 text-white">
        سفارش <span class="text-lg">{{ verta($order->created_at)->format("Y/m/d :: H:i")}}</span>
    </h1>

    <livewire:search-input />
    @foreach ($order->orderLines as $item)
        <div class="bg-white mx-4 mt-4 rounded-2xl shadow-lg p-3 flex items-center">
            <a href="/product/{{ $item->product->id }}">
                <img class="w-24 h-24 object-cover rounded-xl border"
                     src="{{ $item->product->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg' }}"
                     alt="Product Picture">
            </a>
            <div class="mr-4 flex flex-col justify-between gap-1">
                <h3 class="text-lime-950 text-xl font-dastnevis font-black">{{ $item->product->name }}</h3>
                <span class="text-lime-800 font-dastnevis farsi-number">{{ number_format($item->price) }} تومان</span>
                <div class="text-sm text-gray-700 flex items-center gap-2 mt-1 font-dastnevis">
                    <span>تعداد:</span>
                    <span class="farsi-number font-iransans-bold">{{ $item->qty }}</span>
                </div>
            </div>
        </div>
    @endforeach

    <div class="border-t border-dotted border-lime-950 mx-4 my-6"></div>

    <div class="bg-white mx-4 rounded-2xl shadow-md p-4 flex flex-col gap-3 font-dastnevis text-lg">
        <div class="flex justify-between">
            <span>وضعیت</span>
            <span class="font-black">{{ $order->status }}</span>
        </div>
        <div class="flex justify-between">
            <span>جمع کل</span>
            <span class="font-iransans-bold farsi-number">
                {{ number_format($order->total) }} <span class="font-dastnevis">تومان</span>
            </span>
        </div>
    </div>

    <livewire:footer-menu />
</div>
