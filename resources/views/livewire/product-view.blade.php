
<div dir="rtl" class="mb-10 bg-gradient-to-b from-coral-from to-coral-to min-h-screen pb-16 flex flex-col md:items-center">

    <!-- دکمه بازگشت به دسته -->
    <a href="/products/{{ $product->category->id }}" class="text-white text-sm underline mt-2 self-start px-4">
        ← بازگشت به فهرست {{ $product->category->name }}
    </a>

    <!-- عنوان محصول -->
    <h1 class="font-dastnevis text-2xl mt-2 px-4 text-white text-center">
        {{ $product->category->name }} :: {{ $product->name }}
    </h1>

    <!-- نوار جستجو -->
    <div class="sticky top-12 z-20 w-full bg-coral-to/80 backdrop-blur-md shadow-sm">
        <livewire:search-input />
        <livewire:category-scroll-list :categoryId="$product->category->id" />
    </div>

    <!-- اطلاعات محصول -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col justify-center mx-4 mt-4 transition-all duration-300 animate-fade-in" wire:loading.remove>
        <div class="aspect-[16/9] overflow-hidden">
            <img
                class="w-full h-full object-cover object-center"
                src="{{ $product->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg' }}"
                alt="{{ $product->name }}">
        </div>

        <div class="m-4">
            <h3 class="text-xl font-dastnevis text-lime-900 pt-4 text-center">{{ $product->name }}</h3>

            @php use Illuminate\Support\Str; @endphp
            <div class="prose max-w-none font-dastnevis mb-10">
                {!! Str::markdown(strip_tags($product->description)) !!}
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

    <!-- بارگذاری -->
    <div wire:loading>
        @livewire('placeholder')
    </div>

    <!-- منوی پایین -->
    <livewire:footer-menu />
</div>
