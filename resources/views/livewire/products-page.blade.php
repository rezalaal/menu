
<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-full pb-16 flex flex-col md:items-center">
    <!-- عنوان دسته -->
    <h1 class="font-dastnevis font-black text-3xl mt-4 px-4 text-white text-center">{{ $categoryName }}</h1>

    <!-- توضیح کمکی -->
    <p class="text-xs text-center text-white/80 mt-2 px-4">
        برای مشاهده محصولات، دسته مورد نظر را انتخاب یا به پایین اسکرول کنید.
    </p>
    <livewire:search-input />
    <!-- نوار جستجو -->
    <div class="sticky top-12 z-20 w-full bg-coral-to/80 backdrop-blur-md shadow-sm">
        
        <livewire:category-scroll-list :categoryId="$categoryId" />
    </div>

    <!-- نمایش حالت بارگذاری -->
    <div wire:loading>
        @livewire('placeholder')
    </div>

    <!-- فهرست محصولات -->
    <livewire:product-list :category="$categoryId" wire:loading.remove class="animate-fade-in transition-all duration-300"/>

    <!-- منوی پایین صفحه -->
    <livewire:footer-menu />
</div>
