<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-full pb-48 flex flex-col md:items-center">
    <h1 class="font-dastnevis text-2xl mt-10 px-4 text-white">
        <a href="/products/{{ $product->category->id }}">{{ $product->category->name }}</a>
        ::{{ $product->name }}
    </h1>
    <livewire:search-input />
    <livewire:category-scroll-list :categoryId="$product->category->id">
    <div class="pt-4 mx-4">
        @if ($product->getFirstMediaUrl() == null)
            <img class=" rounded-3xl object-center aspect-[1/1] md:aspect-auto w-full shadow-2xl" src="{{ config('app.url').'/images/category.jpg' }}" alt="Product Picture">    
        @else
            <img class=" rounded-3xl object-center aspect-[1/1] shadow-2xl" src="{{ $product->getFirstMediaUrl() }}" alt="Product Picture">    
        @endif 
        <h3 class="text-justify font-dastnevis text-2xl text-lime-950 pt-4">{{ $product->description}}</h3>
        <div class="flex flex-row justify-between items-center pt-4">
            <span class="font-dastnevis text-2xl text-lime-800">قیمت </span>
            <span class="font-dastnevis text-2xl text-lime-800">{{ number_format($product->price) }} تومان</span>
        </div>
        <livewire:add-to-cart-button :product="$product"/>
    </div>
    <livewire:footer-menu />
</div>