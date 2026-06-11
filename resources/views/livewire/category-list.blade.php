<div class="px-4 mt-4 pb-32 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
    @foreach ($categories as $category)
        <a href="/products/{{ $category->id }}" wire:navigate
            class="card-coral overflow-hidden group hover:scale-[1.03] active:scale-[0.97] transition-all duration-300">
            <div class="aspect-square overflow-hidden">
                <img src="{{ $category->getFirstMediaUrl() ?: asset('images/placeholder.png') }}"
                    alt="{{ $category->name }}"
                    class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500">
            </div>

            <div class="p-3 text-center">
                <h3 class="font-dastnevis text-sm text-coral-from truncate">{{ $category->name }}</h3>
            </div>

            <div class="absolute top-2 left-2 w-7 h-7 flex items-center justify-center bg-coral text-white text-[10px] rounded-full shadow-soft font-iransans-bold farsi-number">
                {{ $category->products_count ?? 0 }}
            </div>
        </a>
    @endforeach
</div>
