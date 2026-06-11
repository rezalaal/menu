<div dir="rtl" class="min-h-screen pb-32">
    <div class="bg-gradient-brand rounded-b-3xl shadow-soft p-6 pt-8">
        <h1 class="font-dastnevis text-3xl text-white text-shadow text-center">{{ $categoryName }}</h1>
        <p class="text-xs text-center text-white/70 mt-2 font-iransans-thin">
            برای مشاهده محصولات، دسته مورد نظر را انتخاب یا به پایین اسکرول کنید.
        </p>
    </div>

    <div class="px-4 mt-2">
        <livewire:search-input />
    </div>

    <div class="sticky top-0 z-20 bg-gradient-warm/90 backdrop-blur-md shadow-soft mt-2 rounded-2xl mx-2">
        <livewire:category-scroll-list :categoryId="$categoryId" />
    </div>

    <div wire:loading>
        <div class="px-4 mt-4 grid grid-cols-2 gap-4">
            @for ($i = 0; $i < 4; $i++)
                <div class="bg-white/60 rounded-2xl h-64 animate-pulse"></div>
            @endfor
        </div>
    </div>

    <livewire:product-list :category="$categoryId" wire:loading.remove />

    <livewire:footer-menu />
</div>
