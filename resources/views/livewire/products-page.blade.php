<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-full pb-16 flex flex-col md:items-center">
    <h1 class="font-dastnevis font-black text-3xl mt-4 px-4 text-white">{{ $categoryName }}</h1>
    <livewire:search-input />
    <livewire:category-scroll-list :categoryId="$categoryId">

        <div wire:loading>
            @livewire('placeholder')
        </div>

    <livewire:product-list :category="$categoryId" wire:loading.remove/>
    <livewire:footer-menu />
</div>
