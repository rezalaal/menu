<div class="px-4 mt-4 pb-32 grid grid-cols-2 md:grid-cols-3 gap-4">
    @foreach ($products as $product)
        <div class="card-coral overflow-hidden flex flex-col group hover:scale-[1.02] active:scale-[0.98] transition-all duration-300">
            <a href="/product/{{ $product->id }}" wire:navigate>
                <div class="aspect-[4/3] overflow-hidden">
                    <img
                        class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500"
                        src="{{ $product->getFirstMediaUrl() ?: asset('images/placeholder.png') }}"
                        alt="Product Picture"
                    >
                </div>
            </a>

            <div class="p-3 flex flex-col gap-2 flex-1">
                <a href="/product/{{ $product->id }}" wire:navigate>
                    <h3 class="text-center text-coral-from font-iransans-thin text-sm leading-snug truncate">
                        {{ $product->name }}
                    </h3>
                </a>

                <div class="flex items-center justify-center gap-1 text-xs">
                    <span class="farsi-number font-iransans-bold text-coral-from/70">{{ number_format($product->price) }}</span>
                    <span class="font-iransans-thin text-coral-from/50">تومان</span>
                </div>

                <div class="mt-auto">
                    <livewire:add-to-cart-button :product="$product"/>
                </div>
            </div>
        </div>
    @endforeach
</div>
