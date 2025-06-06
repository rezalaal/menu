<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to min-h-screen pb-48 flex flex-col items-center">
    <h1 class="font-dastnevis text-3xl mt-10 text-white">پروفایل</h1>

    <div class="w-[90%] sm:w-[80%] md:w-[60%] lg:w-[40%] xl:w-[30%] mt-6 bg-white/20 rounded-3xl shadow-lg p-6 flex flex-col items-center">
        <div class="w-40 h-40 bg-white rounded-full flex items-center justify-center shadow-inner mb-4">
            <svg class="text-lime-950 w-24 h-24" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </div>

        @if (auth()->user())
            <span class="farsi-number text-center text-2xl sm:text-3xl font-bold text-white mt-2 font-dastnevis farsi-number">
                {{ auth()?->user()->username }}
            </span>

            <button wire:click="logoff" class="mt-6 text-lg font-dastnevis bg-white text-lime-900 px-6 py-2 rounded-xl shadow hover:bg-lime-100 transition">
                خروج
            </button>
        @else
            <livewire:login-form />
        @endif
    </div>

    <livewire:footer-menu />
</div>
