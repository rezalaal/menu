<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-screen pb-48 flex flex-col md:items-center">
        <h1 class="font-dastnevis text-3xl font-black mt-10 px-4 text-white">سفارش <span class="text-lg">{{ verta($order->created_at)->format("Y/m/d :: H:i")}}</span></h1>
    <livewire:search-input />
    @foreach ($order->orderLines as $item)
        <div class="flex flex-row items-center px-4 mt-6">
            @if ($item->product->getFirstMediaUrl())
                <a href="/product/{{ $item->product->id }}">
                    <img class="shadow-2xl rounded-3xl w-28 h-28 object-center aspect-[1/1] shadow-2xl" src="{{ $item->product->getFirstMediaUrl() }}" alt="Product Picture">
                </a>
            @else
                <a href="/product/{{ $item->product->id }}">
                    <img class="shadow-2xl rounded-3xl w-28 h-28 object-center aspect-[1/1] shadow-2xl" src="{{ config('app.url').'/images/category.jpg' }}" alt="Product Picture">    
                </a>
            @endif
            <div class="px-4">
                <h3 class="text-xl font-dastnevis text-2xl font-black text-lime-950">{{ $item->product->name }}</h3>
                <span class="font-dastnevis farsi-number text-lime-800">{{ number_format($item->price) }} تومان</span>
                <div wire:loading.remove class="mt-2 flex items-center gap-2 font-dastnevis">
                    <span>تعداد</span>                                                                               
                    <span class="font-iransans-bold farsi-number"> {{ $item->qty }}</span>                                                                                
                </div>
                <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
            </div>
        </div>
    @endforeach

    <div class="mx-4 mt-4 border-dotted border-2 border-lime-950"></div>
    <div class="px-8 flex justify-between items-center flex-row mt-4">
        <span class="font-dastnevis">وضعیت</span>
        <span class="font-dastnevis font-2xl font-black">{{ $order->status }}</span>
    </div>
    <div class="px-8 flex justify-between items-center flex-row mt-4">
        <span class="font-dastnevis"> جمع : </span>
        <span class="font-iransans-bold farsi-number"> {{ number_format($order->total) }} <span class="font-dastnevis">تومان</span></span>
    </div>
    
    <livewire:footer-menu />
</div>
