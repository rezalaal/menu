<div
    x-show="showSettingsModal === '{{ $section }}'"
    x-cloak
    x-transition:enter="transition-all duration-300 ease-out"
    x-transition:enter-start="opacity-0 translate-x-8"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition-all duration-200 ease-in"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-8"
    @close-modal.window="(event.detail.includes('{{ $section }}')) ? showSettingsModal = null : null"
    class="fixed inset-0 z-[60] flex flex-col bg-coral-body overflow-y-auto"
    dir="rtl"
>
    <div class="sticky top-0 z-10 bg-coral-header/90 backdrop-blur-lg p-4 flex items-center">
        <button
            @click="showSettingsModal = null"
            class="w-8 h-8 flex items-center justify-center rounded-full bg-white/60 text-coral-from hover:bg-coral hover:text-white transition-all"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <h2 class="flex-1 text-center font-dastnevis text-coral-from text-lg">
            {{ $section == 'about' ? 'درباره ما' : ($section == 'work_hours' ? 'ساعت کار' : 'اطلاعات تماس') }}
        </h2>
        <div class="w-8"></div>
    </div>

    <div class="flex-1 p-6">
        <div class="card-coral p-6 leading-relaxed">
            <div class="text-sm font-iransans-thin text-coral-from/80 space-y-3">
                {!! Str::markdown(strip_tags($content)) !!}
            </div>
        </div>
    </div>

    <div class="sticky bottom-0 bg-coral-body/90 backdrop-blur-lg border-t border-coral/10 p-4">
        <button
            class="btn-outline w-full py-2.5 rounded-xl text-sm"
            @click="showSettingsModal = null"
        >
            بازگشت
        </button>
    </div>
</div>
