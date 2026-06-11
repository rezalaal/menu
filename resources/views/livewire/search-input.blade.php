<div class="relative mt-4 w-full px-4">
    <div class="relative">
        <input wire:model.live="search"
            class="input-coral pr-10 farsi-number"
            type="search"
            placeholder="جستجو">
        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-coral/50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M15.75 10.5a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"/>
        </svg>
    </div>

    <span wire:loading class="text-coral-from/60 text-xs font-iransans-thin mt-1 block animate-pulse">در حال جستجو...</span>

    @if ($products)
        @foreach ($products as $product)
            <div class="card-coral p-3 mt-3 flex items-center gap-3 animate-fade-in-up">
                <a href="/product/{{ $product->id }}" wire:navigate class="flex-shrink-0">
                    <img
                        class="w-16 h-16 rounded-xl object-cover shadow-soft"
                        src="{{ $product->getFirstMediaUrl() ?: asset('images/placeholder.png') }}"
                        alt="Product Picture"
                    >
                </a>

                <div class="flex-1 min-w-0">
                    <a href="/product/{{ $product->id }}" wire:navigate>
                        <h3 class="font-iransans-thin text-sm text-coral-from truncate">
                            {{ $product->name }}
                        </h3>
                    </a>

                    <div class="flex items-center gap-1 mt-1">
                        <span class="farsi-number font-iransans-bold text-xs text-coral-from/70">{{ number_format($product->price) }}</span>
                        <span class="font-iransans-thin text-xs text-coral-from/50">تومان</span>
                    </div>

                    <div class="mt-2">
                        <livewire:add-to-cart-button :product="$product"/>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
