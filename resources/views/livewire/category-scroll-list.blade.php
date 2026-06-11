<div x-data="{ loading: false }"
     x-on:category-loading.window="loading = true"
     class="flex flex-col w-full overflow-hidden">

    <template x-if="loading">
        <div class="bg-coral/20 text-coral-from text-xs p-2 text-center rounded-xl font-iransans-thin animate-pulse mx-4">
            در حال بارگذاری دسته‌بندی...
        </div>
    </template>

    <ul class="flex scroll-smooth snap-start overflow-x-auto max-w-full box-border px-4 py-2 no-scrollbar gap-2">
        @foreach ($categories as $category)
            @php
                $isActive = $category->id == $categoryId;
            @endphp
            <li class="snap-start">
                <a
                    href="#"
                    wire:click.prevent="category({{ $category->id }})"
                    class="whitespace-nowrap px-4 py-2 rounded-full text-sm font-iransans-thin transition-all duration-300 block
                        {{ $isActive
                            ? 'bg-coral text-white shadow-glow scale-105 font-iransans-bold'
                            : 'bg-white/70 text-coral-from/70 hover:bg-white hover:text-coral-from shadow-soft' }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
