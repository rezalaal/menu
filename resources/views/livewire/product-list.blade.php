<div class="mt-4 px-4 pb-96 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
    @foreach ($products as $product)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col justify-between">
            <!-- تصویر محصول با نسبت 16:9 -->
            <a href="/product/{{ $product->id }}" wire:navigate>
                <div class="aspect-[16/9] overflow-hidden">
                    <img
                        class="w-full h-full object-cover object-center"
                        src="{{ $product->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg' }}"
                        alt="Product Picture"
                    >
                </div>
            </a>

            <!-- محتوای کارت -->
            <div class="p-3 flex flex-col justify-between flex-1">
                <!-- نام محصول -->
                <a href="/product/{{ $product->id }}" wire:navigate>
                    <h3 class="text-center text-lime-900 font-dastnevis text-lg leading-snug pt-2">
                        {{ $product->name }}
                    </h3>
                </a>

                <!-- قیمت -->
                <div class="flex justify-between items-center text-sm font-iransans-bold text-lime-700 mt-2">
                    <span class="farsi-number">{{ number_format($product->price) }}</span>
                    <span class="font-dastnevis">تومان</span>
                </div>

                <!-- دکمه افزودن به سبد -->
                <div class="mt-2">
                    <livewire:add-to-cart-button :product="$product"/>
                </div>
            </div>
        </div>
    @endforeach
</div>
