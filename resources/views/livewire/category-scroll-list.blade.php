<div x-data="{ loading: false }"
     x-on:category-loading.window="loading = true"
     class="flex flex-col w-full overflow-hidden">

    <template x-if="loading">
        <div class="bg-yellow-100 text-yellow-800 p-2 text-center rounded shadow mb-2 font-dastnevis">
            در حال بارگذاری دسته‌بندی، لطفاً صبر کنید...
        </div>
    </template>

    <ul class="flex text-3xl scroll-smooth snap-start overflow-x-auto max-w-full box-border m-4 no-scrollbar">
        @foreach ($categories as $category)
            @php
                $isActive = $category->id == $categoryId;
                $baseClass = 'font-dastnevis text-black text-sm cursor-pointer px-4 py-2 rounded-xl shadow-md flex flex-row mx-2 whitespace-nowrap';
                $bgClass = $isActive ? 'bg-lime-100' : 'bg-lime-200';
            @endphp
            <li>
                <a 
                    href="#" 
                    wire:click.prevent="category({{ $category->id }})"
                    class="{{ $baseClass }} {{ $bgClass }}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
