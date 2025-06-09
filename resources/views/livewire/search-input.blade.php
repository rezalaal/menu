<div class="relative mt-4 w-full px-4 mb-2">

    <input wire:model.live="search" class="border-1 font-dastnevis placeholder-lime-900 border-lime-950 rounded-lg bg-[#ECFAE5] w-full text-xl outline-0 px-4 py-2 shadow-2xl text-lime-800" type="search" placeholder="جستجو">
    <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
    @if ($products)

        @foreach ($products as $product)
            <div class="mt-4 pb-4 px-4 bg-lime-100 rounded-3xl shadow-md">
                <div class="grid grid-cols-[auto_1fr] gap-4 items-start">
                    <a href="/product/{{ $product->id }}" wire:navigate class="block mt-2">
                        <img
                            class="rounded-2xl w-28 h-28 object-cover shadow-lg"
                            src="{{ $product->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg' }}"
                            alt="Product Picture"
                        >
                    </a>

                    <div class="flex flex-col justify-between h-full pt-2">
                        <a href="/product/{{ $product->id }}" wire:navigate>
                            <h3 class="text-right font-dastnevis text-xl text-lime-950 leading-snug mt-1">
                                {{ $product->name }}
                            </h3>
                        </a>

                        <div class="flex justify-between items-center mt-3">
                            <div class="text-lime-800 font-iransans-bold text-lg">
                                <span class="farsi-number">{{ number_format($product->price) }}</span>
                                <span class="font-dastnevis ml-1">تومان</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <livewire:add-to-cart-button :product="$product"/>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

    @endif
</div>
