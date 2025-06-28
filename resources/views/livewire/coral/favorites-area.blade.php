<div class="z-999">
    <button
        @click="window.dispatchEvent(new CustomEvent('show-favorites')); console.log('DISPATCHED')"
        class="fixed flex justify-center items-center left-0 rounded-tr-xl bg-coral text-white shadow-lg hover:bg-orange-500 transition"
        style="bottom: 8.4rem;padding: 0.75rem 0.875rem"

    >
        <!-- آیکون -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21.8 7.3c0 4.6-9.8 11.2-9.8 11.2S2.2 11.9 2.2 7.3C2.2 4.6 4.6 2.2 7.3 2.2c1.7 0 3.3.8 4.3 2 1-1.2 2.6-2 4.3-2 2.7 0 5.1 2.4 5.1 5.1z"/>
        </svg>
        <span class="farsi-number font-iransans-bold absolute left-2 top-1 text-[9px]"
        >{{ $favoritesCount }}</span>
    </button>



</div>
