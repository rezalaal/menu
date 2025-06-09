<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to min-h-screen pb-48 flex flex-col items-center space-y-4">
    <h1 class="font-dastnevis font-black text-3xl mt-10 px-4 text-white">سبد خرید</h1>
    <livewire:search-input />

    @if ($cartItems)
        <div class="flex flex-col items-center w-full pt-4">
            @php
                $total = $cartItems->sum(fn($cartItem) => $cartItem->product->price * $cartItem->qty);
            @endphp

            @foreach ($cartItems as $item)
                <div class="bg-white rounded-2xl shadow-lg w-full max-w-sm mx-4 my-2 p-4 flex gap-4 transition-transform hover:scale-[1.01]">
                    <a href="/product/{{ $item->product->id }}">
                        <img class="rounded-xl w-24 h-24 object-cover aspect-[1/1]"
                            src="{{ $item->product->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg' }}"
                            alt="Product Picture">
                    </a>
                    <div class="flex flex-col justify-between flex-grow">
                        <h3 class="text-xl font-dastnevis font-black text-lime-950">{{ $item->product->name }}</h3>
                        <span class="font-dastnevis farsi-number text-lime-800">{{ number_format($item->product->price) }} تومان</span>
                        <div wire:loading.remove class="mt-2 flex items-center gap-2 font-dastnevis">
                            <span class="pl-2">تعداد</span>
                            <button wire:click="increase({{ $item->id }})" class="bg-lime-100 text-lime-950 w-8 h-8 rounded-full text-xl">+</button>
                            <span class="font-iransans-bold farsi-number">{{ $item->qty }}</span>
                            <button wire:click="decrease({{ $item->id }})" class="bg-lime-100 text-lime-950 w-8 h-8 rounded-full text-xl">-</button>
                        </div>                        
                    </div>
                </div>
            @endforeach

            @if ($total > 0)
                <div class="w-[80%] bg-lime-100/70 rounded-2xl shadow-inner p-6 flex flex-col items-center gap-4 mx-6">
                    <div class="w-full max-w-sm border-b border-lime-400 pb-2 flex justify-between items-center text-xl">
                        <span class="font-dastnevis text-lime-800">جمع کل</span>
                        <span class="font-iransans-bold farsi-number text-lime-950">{{ number_format($total) }} <span class="font-dastnevis">تومان</span></span>
                    </div>

                    <div class="w-full max-w-sm border-b border-lime-400 pb-2 flex justify-between items-center text-lg">
                        <span class="font-dastnevis text-lime-800">میز</span>
                        <span class="font-iransans-bold text-lime-950">{{ $table }}</span>
                    </div>

                    <button wire:click="addToBag" wire:loading.remove class="w-full max-w-sm mt-4 bg-lime-700 hover:bg-lime-800 text-white font-dastnevis text-xl py-3 rounded-xl shadow-lg transition">
                        ثبت سفارش
                    </button>
                </div>

                <div wire:loading class="pt-4 text-white font-dastnevis text-lg">در حال ثبت سفارش...</div>
            @else
                <div class="flex flex-col items-center justify-center mt-10">
                    <svg class="text-lime-950 w-20 h-20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="..."/>
                    </svg>
                    <h3 class="text-lime-800 text-lg font-dastnevis font-black mt-2">سبد خرید خالی است</h3>
                </div>
            @endif
        </div>
    @else
        <div class="flex flex-col items-center justify-center mt-20">
            <svg class="text-lime-950 w-24 h-24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="..." />
            </svg>
            <h3 class="text-lime-800 text-2xl font-dastnevis font-black mt-2">سبد خرید خالی است</h3>
        </div>
    @endif

    @auth
        @if(session()->has('tableId'))
            <livewire:call-waiter />
        @endif
    @endauth

    <livewire:footer-menu />
</div>