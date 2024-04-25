<div class="mt-4 px-4 pb-96 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6  gap-6">
    @foreach ($products as $product)
        <div class="mt-4 cursor-pointer">
            @if ($product->getFirstMediaUrl() == null)
                <a href="/product/{{ $product->id }}" wire:navigate>
                    <img class=" rounded-3xl shadow-lg  object-center aspect-[1/1]" src="{{ config('app.url').'/images/category.jpg' }}" alt="Product Picture">    
                </a>
            @else
                <a href="/product/{{ $product->id }}" wire:navigate>
                    <img class=" rounded-3xl shadow-lg  object-center aspect-[1/1]" src="{{ $product->getFirstMediaUrl() }}" alt="Product Picture">    
                </a>
            @endif            
            <a href="/product/{{ $product->id }}" wire:navigate>
                <h3 class="text-2xl text-center font-dastnevis pt-4">{{ $product->name }}</h3>
            </a>
            <div class="flex justify-evenly p-2 text-2xl font-iransans-bold text-lime-800">
                <span class="farsi-number">{{ number_format($product->price) }}</span>
                <span class="font-dastnevis">تومان</span>
            </div>
            <livewire:add-to-cart-button :product="$product"/>
        </div>
    @endforeach
</div>
