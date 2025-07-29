<div
    x-show="showSettingsModal === '{{ $section }}'"
    x-transition
    x-cloak
    @close-modal.window="(event.detail.includes('{{ $section }}')) ? showSettingsModal = null : null"
    class="fixed inset-0 bg-coral-body z-50 flex flex-col max-h-screen overflow-y-auto px-6 py-10"
    style="display: none;"
    dir="rtl"
>
    <!-- آیکون بازگشت -->
    <x-modal-back-button action="showSettingsModal = null" />

    <div class="text-sm font-iransans-thin text-black leading-relaxed space-y-2 max-w-xl mx-auto">
        {!! Str::markdown(strip_tags($content)) !!}
    </div>

    <button
        class="text-coral border border-coral py-2 px-5 rounded mt-10 font-iransans-thin hover:bg-coral hover:text-white transition"
        @click="showSettingsModal = null"
    >
        بازگشت به خانه
    </button>
</div>
