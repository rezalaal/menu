
<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-full pb-16 flex flex-col md:items-center">
    <h1 class="font-dastnevis text-3xl mt-4 px-4 text-white">منو</h1>

    <livewire:search-input />

    <div wire:loading>
        @livewire('placeholder')
    </div>

    <livewire:category-list wire:loading.remove />

    <livewire:footer-menu />
</div>
