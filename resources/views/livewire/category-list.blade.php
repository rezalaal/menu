<div class="mt-4 px-4 grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7  gap-6">
    @foreach ($categories as $category)
        <div class="mt-4 cursor-pointer ">
            @if ($category->getFirstMediaUrl() == null)
                <a href="/products/{{ $category->id }}" wire:navigate>
                    <img class="rounded-full w-32 h-32 md:w-60 md:h-60" src="{{ config('app.url').'/images/category.jpg' }}" alt="Menu Picture">    
                </a>
            @else
                <a href="/products/{{ $category->id }}" wire:navigate>
                    <img class="rounded-full w-32 h-32 md:w-60 md:h-60" src="{{ $category->getFirstMediaUrl() }}" alt="Menu Picture">    
                </a>
            @endif
            
            <a href="/products/{{ $category->id }}" wire:navigate>
                <h3 class="text-center text-lime-950 font-dastnevis pt-4">{{ $category->name }}</h3>
            </a>
        </div>
    @endforeach
</div>
