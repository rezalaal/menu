<div class="flex flex-col">
    <ul class="flex text-3xl scroll-smooth snap-start overflow-x-auto min-h-0 m-4 no-scrollbar">
    @foreach ($categories as $category)
            @if($category->id == $categoryId)
            <li wire:click="category({{ $category->id }})" class="bg-lime-100 font-iransans-ultralight text-black text-sm cursor-pointer px-4 py-2 rounded-xl shadow-md flex flex-row mx-2 whitespace-nowrap">{{ $category->name }}</li>
            @else
                <li wire:click="category({{ $category->id }})" class="bg-lime-200 font-iransans-ultralight text-black text-sm cursor-pointer px-4 py-2 rounded-xl shadow-md flex flex-row mx-2 whitespace-nowrap">{{ $category->name }}</li>
            @endif
        @endforeach
    </ul>
</div>
