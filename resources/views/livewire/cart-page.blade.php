<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-screen pb-48 flex flex-col md:items-center">
    <h1 class="font-dastnevis font-black text-3xl mt-10 px-4 text-white">سبد خرید</h1>
    <livewire:search-input />
    @if ($cartItems)
        <div class="flex flex-col justify-start pt-4">
            @php
                $total = $cartItems->sum(function ($cartItem) {
                        return $cartItem->product->price * $cartItem->qty;
                    });                
            @endphp
            @foreach ($cartItems as $item)
                <div class="flex flex-row items-center px-4 my-2">
                    @if ($item->product->getFirstMediaUrl())
                        <a href="/product/{{ $item->product->id }}">
                            <img class="shadow-2xl rounded-xl w-28 h-28 object-center aspect-[1/1] shadow-2xl" src="{{ $item->product->getFirstMediaUrl() }}" alt="Product Picture">
                        </a>
                    @else
                        <a href="/product/{{ $item->product->id }}">
                            <img class="shadow-2xl rounded-xl w-28 h-28 object-center aspect-[1/1] shadow-2xl" src="{{ config('app.url').'/images/category.jpg' }}" alt="Product Picture">    
                        </a>
                    @endif
                    <div class="px-4">
                        <h3 class="text-xl font-dastnevis font-black text-lime-950">{{ $item->product->name }}</h3>
                        <span class="font-dastnevis farsi-number text-lime-800">{{ number_format($item->product->price) }} تومان</span>
                        <div wire:loading.remove class="mt-2 flex items-center gap-2 font-dastnevis">
                            <span class="pl-4">تعداد</span>                                                            
                            <button wire:click="increase({{ $item->id }})" class="flex justify-center items-center bg-white shadow-sm shadow-white rounded-full text-2xl text-lime-950 w-8 h-8">+</button>
                            <span class="font-iransans-bold farsi-number"> {{ $item->qty }}</span>                                                            
                            <button wire:click="decrease({{ $item->id }})" class="flex justify-center items-center bg-white shadow-sm shadow-white rounded-full text-2xl text-lime-950 w-8 h-8">-</button>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($total > 0)
                <div class="mx-4 mt-4 border-dotted border-2 border-lime-950"></div>
                <div class="px-8 flex justify-between items-center flex-row mt-4">
                    <span class="font-dastnevis"> جمع : </span>
                    <span class="font-iransans-bold farsi-number"> {{ number_format($total) }} <span class="font-dastnevis">تومان</span></span>
                </div>
                <div class="px-8 flex justify-between items-center flex-row mt-4">
                    <span class="font-dastnevis"> میز : </span>
                    <span class="font-iransans-bold"> {{ $table }}</span>
                </div>
                <button wire:click="addToBag" wire:loading.remove class="pt-2 mx-4 text-2xl shadow-xl mt-10 rounded-xl gap-2 w-100 font-dastnevis tex-xl bg-white text-lime-950 tex-center flex items-center justify-center ">
                    ثبت سفارش                        
                     
                </button>
                <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
                @else
                <div class="w-100 flex flex-row items-center justify-center">
                    <div class="flex flex-col items-center justify-center w-40">
                        <svg class="text-lime-950 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <h3 class="color-lime-600 text-lg font-dastnevis font-black">سبد خرید خالی است</h3>
                    </div>
                </div>
                @endif
        </div>
    @else
        <div class="flex flex-col items-center justify-center ">
            <svg class="text-lime-950 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
            <h3 class="color-lime-600 text-3xl font-dastnevis font-black">سبد خرید خالی است</h3>
        </div>
    @endif
    <livewire:footer-menu />
</div>
