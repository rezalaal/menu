<div dir="rtl" class="mb-10 bg-gradient-to-b from-coral-from to-coral-to min-h-screen pb-16 flex flex-col md:items-center">
    <h1 class="font-dastnevis text-2xl mt-4 px-4 text-white">
        <a href="/products/{{ $product->category->id }}">{{ $product->category->name }}</a>
        ::{{ $product->name }}
    </h1>
    <livewire:search-input />
    <livewire:category-scroll-list :categoryId="$product->category->id">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col justify-center mx-4" wire:loading.remove>
        @if ($product->getFirstMediaUrl() == null)
            <div class="aspect-[16/9] overflow-hidden">
                <img
                    class="w-full h-full object-cover object-center"
                    src="{{ config('app.url').'/images/category.jpg' }}"
                    alt="Product Picture">
            </div>
        @else
            <div class="aspect-[16/9] overflow-hidden">
                <img
                    class="w-full h-full object-cover object-center"
                    src="{{ $product->getFirstMediaUrl() }}"
                    alt="Product Picture">
            </div>
        @endif

            <div class="m-4">
                <h3 class="text-xl font-dastnevis text-lime-900 pt-4 text-center">{{ $product->name }}</h3>
                @php
                    use Illuminate\Support\Str;
                @endphp

                <div class="prose max-w-none font-dastnevis mb-10 ">
                    {!! Str::markdown($product->description) !!}
                </div>


                <div class="flex justify-between items-center pt-4 text-lime-800 text-lg font-dastnevis">
                    <span>قیمت:</span>
                    <span class="farsi-number">{{ number_format($product->price) }} تومان</span>
                </div>

                <div class="mt-4">
                    <livewire:add-to-cart-button :product="$product" />
                </div>
            </div>
    </div>
        <div wire:loading>
            @livewire('placeholder')
        </div>
    <livewire:footer-menu />
</div>
