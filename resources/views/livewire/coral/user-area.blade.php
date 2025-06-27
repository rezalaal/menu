<div>
    <button
        wire:click="profile"
        class="fixed flex justify-center items-center bottom-24 left-0 rounded-tr-xl bg-coral text-white p-3 shadow-lg hover:bg-orange-500 transition"
    >
        <!-- آیکون -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
        </svg>

        <span x-show="cartCount > 0" x-text="cartCount"
              class="farsi-number font-iransans-bold absolute left-2 top-1 text-[9px]"
        ></span>
    </button>
</div>
