<div class="px-4 mt-4 grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-5">
    @foreach ($categories as $category)
        <a href="/products/{{ $category->id }}" wire:navigate class="flex flex-col items-center space-y-2">
            <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-lime-600 shadow-md">
                <img src="{{ $category->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg' }}" alt="{{ $category->name }}"
                     class="w-full h-full object-cover object-center">
            </div>
            <h3 class="text-center text-lime-950 font-dastnevis text-sm">{{ $category->name }}</h3>
        </a>
    @endforeach
</div>
