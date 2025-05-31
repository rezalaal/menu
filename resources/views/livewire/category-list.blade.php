<div class="px-4 grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-5">
    @foreach ($categories as $category)
        <div class="flex flex-col items-center">
            <a href="/products/{{ $category->id }}" wire:navigate>
                <div class="egg-container">
                    <div class="egg-shape" style="background-image: url('{{ $category->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg' }}')">
                    </div>
                </div>
            </a>
            <a href="/products/{{ $category->id }}" wire:navigate>
                <h3 class="-mt-4 text-center text-lime-950 font-dastnevis">{{ $category->name }}</h3>
            </a>
        </div>
    @endforeach
</div>
