<div class="relative mx-4 md:px-4 mt-4">

    <input wire:model.live="search" class="border-1 font-dastnevis placeholder-lime-900 border-lime-950 rounded-lg bg-white w-full text-xl outline-0 px-4 py-2 shadow-2xl text-lime-800" type="search" placeholder="جستجو">
    <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
    @if ($products)

        @foreach ($products as $product)
        <div class="mt-4 pb-4 px-4 bg-lime-100 rounded-3xl">
            <div class="relative top-50 flex flex-cols gap-4 items-center">
                <div class="mt-4 cursor-pointer">
                    @if ($product->getFirstMediaUrl() == null)
                        <a href="/product/{{ $product->id }}" wire:navigate>
                            <img class=" rounded-xl w-36 h-36 object-center aspect-[1/1] shadow-2xl" src="{{ config('app.url').'/images/category.jpg' }}" alt="Product Picture">
                        </a>
                    @else
                        <a href="/product/{{ $product->id }}" wire:navigate>
                            <img class=" rounded-xl w-36 h-36 object-center aspect-[1/1] shadow-2xl" src="{{ $product->getFirstMediaUrl() }}" alt="Product Picture">
                        </a>
                    @endif
                </div>
                <div>
                    <a href="/product/{{ $product->id }}" wire:navigate>
                        <h3 class="text-xl text-right font-dastnevis pt-1">{{ $product->name }}</h3>
                    </a>
                    <div class="flex justify-around p-2 text-xl font-iransans-bold text-lime-800">
                        <span class="farsi-number">{{ number_format($product->price) }}</span>
                        <span class="font-dastnevis px-4">تومان</span>
                    </div>
                    <livewire:add-to-cart-button :product="$product"/>
                </div>
            </div>
        </div>
        @endforeach

    @endif
</div>
