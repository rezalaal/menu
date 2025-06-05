<div class="flex flex-col w-full overflow-hidden">
    <ul class="flex text-3xl scroll-smooth snap-start overflow-x-auto max-w-full box-border m-4 no-scrollbar">
    @foreach ($categories as $category)
            @if($category->id == $categoryId)
            <li wire:click="category({{ $category->id }})" class="bg-lime-100  font-dastnevis text-black text-sm cursor-pointer px-4 py-2 rounded-xl shadow-md flex flex-row mx-2 whitespace-nowrap">{{ $category->name }}</li>
            @else
                <li wire:click="category({{ $category->id }})" class="bg-lime-200  font-dastnevis text-black text-sm cursor-pointer px-4 py-2 rounded-xl shadow-md flex flex-row mx-2 whitespace-nowrap">{{ $category->name }}</li>
            @endif
        @endforeach
    </ul>
</div>
