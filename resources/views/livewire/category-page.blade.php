<div dir="rtl" class="min-h-screen pb-8">
    <div class="bg-gradient-brand rounded-b-3xl shadow-soft p-6 pt-8">
        <h1 class="font-dastnevis text-3xl text-white text-shadow">منو</h1>
    </div>

    <div class="px-4 mt-2">
        <livewire:search-input />
    </div>

    <div wire:loading class="px-4 mt-4">
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white/60 rounded-2xl h-48 animate-pulse"></div>
            <div class="bg-white/60 rounded-2xl h-48 animate-pulse"></div>
            <div class="bg-white/60 rounded-2xl h-48 animate-pulse"></div>
            <div class="bg-white/60 rounded-2xl h-48 animate-pulse"></div>
        </div>
    </div>

    <livewire:category-list wire:loading.remove />

    <livewire:footer-menu />
</div>
