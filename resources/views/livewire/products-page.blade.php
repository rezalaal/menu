<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-screen pb-48 flex flex-col md:items-center">
    <h1 class="font-dastnevis font-black text-3xl mt-10 px-4 text-white">{{ $categoryName }}</h1>
    <livewire:search-input />
    <livewire:product-list :category="$categoryId" />
    <livewire:footer-menu />
</div>
