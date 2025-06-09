<div class="pb-16 font-iransans-regular bg-gradient-to-b from-coral-from to-coral-to min-h-screen flex flex-col justify-between items-center p-6">
    <!-- تصویر و عنوان -->
    <div class="flex flex-col items-center mt-6">
        <img class="rounded-full w-44 h-44 shadow-2xl mb-4" src="{{ $tableImageUrl }}" alt="table image">
        <span class="font-mallanna text-4xl pt-2 text-shadow gradient-text animate-gradient text-center">
            {{ $settings['title'] }}
        </span>
        <span class="pt-3 text-white font-dastnevis text-xl text-center" dir="rtl">
            {{ $tableName }}
        </span>
    </div>

    <!-- فرم ورود / تایید شماره -->
    <div  wire:loading.remove class="flex flex-col items-center w-full mt-2 font-dastnevis">
        <!-- پیام انتقال -->
        <div id="redirect-message" class="hidden text-center text-white text-xl bg-lime-700 p-4 rounded-xl shadow-xl mt-6">
            ورود با موفقیت انجام شد. در حال انتقال...
        </div>
        <form id="login-form" class="flex flex-col w-full max-w-sm bg-white/90 rounded-xl shadow-inner p-6 backdrop-blur-lg" wire:submit="login">
            <div class="text-red-900 text-center p-2">@error('mobile') {{ $message }} @enderror</div>

            @if ($loggedIn)
            
            
                <div class="text-center text-2xl text-lime-800 font-iransans-extrabold">
                    @auth
                        <span class="farsi-number">{{ auth()->user()->username }}</span>
                    @endauth
                </div>                
                <button wire:loading.remove
                        class="relative border font-dastnevis rounded-xl bg-lime-700 hover:bg-lime-800 text-white w-full pt-2 pb-1 mt-4 shadow-xl text-xl transition-all duration-300"
                        wire:loading.attr="disabled">
                    ثبت سفارش
                    <span wire:loading class="absolute left-4 top-1/2 transform -translate-y-1/2 loading loading-spinner loading-xs"></span>
                </button>
                <p class="text-xs text-lime-950 farsi-number pt-2 cursor-pointer font-dastnevis hover:underline text-right pr-4"
                    wire:click="logoff">
                    تغییر شماره تلفن
                </p>

            @else
                <input wire:model="mobile"
                    type="tel"
                    dir="rtl"
                    placeholder="مثلاً: 09123456789"
                    class="no-spinner placeholder-lime-600 font-dastnevis rounded-xl bg-white/80 w-full text-xl text-center outline-none p-4 shadow-inner border border-lime-300 text-lime-900 transition-all focus:ring-2 focus:ring-lime-600">

                <p class="text-xs text-center text-gray-700 mt-2">
                    لطفاً شماره موبایل خود را وارد کنید تا سفارش‌تان ثبت شود.
                </p>

                <button wire:loading.remove
                        class="relative border font-dastnevis rounded-xl bg-lime-700 hover:bg-lime-800 text-white w-full pt-2 pb-1 mt-4 shadow-xl text-xl transition-all duration-300"
                        wire:loading.attr="disabled">
                    ثبت سفارش
                    <span wire:loading class="absolute left-4 top-1/2 transform -translate-y-1/2 loading loading-spinner loading-xs"></span>
                </button>

            @endif
        </form>
    </div>

    <div wire:loading>
        <livewire:placeholder>
    </div>
    <!-- اطلاعات تماس -->
    <div class="w-full flex justify-around text-lime-900 text-sm flex-wrap gap-6 mt-4 mb-4">
        <a href="https://instagram.com/{{ $settings['instagram'] }}" target="_blank" class="flex no-underline hover:underline items-center hover:text-pink-200 transition-all">
            <svg class="w-6 h-6 mx-2 fill-current text-pink-600 hover:text-pink-800 transition-colors duration-200" viewBox="0 0 24 24">
                <path d="M7.5 2h9A5.5 5.5 0 0 1 22 7.5v9A5.5 5.5 0 0 1 16.5 22h-9A5.5 5.5 0 0 1 2 16.5v-9A5.5 5.5 0 0 1 7.5 2Zm0 2A3.5 3.5 0 0 0 4 7.5v9A3.5 3.5 0 0 0 7.5 20h9a3.5 3.5 0 0 0 3.5-3.5v-9A3.5 3.5 0 0 0 16.5 4h-9Zm4.5 3.25a4.25 4.25 0 1 1 0 8.5a4.25 4.25 0 0 1 0-8.5Zm0 2a2.25 2.25 0 1 0 0 4.5a2.25 2.25 0 0 0 0-4.5ZM17.75 6a.75.75 0 1 1 0 1.5a.75.75 0 0 1 0-1.5Z"/>
            </svg>
            <span class="font-iransans-ultralight underline">{{ '@' . $settings['instagram'] }}</span>
        </a>

        <a href="tel:{{ $settings['mobile'] }}" class="flex no-underline hover:underline items-center hover:text-green-200 transition-all">
            <svg class="w-6 h-6 mx-2 fill-current text-[#1FC85F]" viewBox="0 0 24 24">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 3.07 8.81a19.79 19.79 0 0 1-3.07-8.63A2 2 0 0 1 2 2h3a2 2 0 0 1 2 1.72 13.33 13.33 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L6.09 10a16 16 0 0 0 7.07 7.07l1.36-1.36a2 2 0 0 1 2.11-.45 13.33 13.33 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
            </svg>
            <span class="font-iransans-ultralight underline farsi-number">{{ $settings['mobile'] }}</span>
        </a>
    </div>
</div>
@push('scripts')
    <script>
        window.addEventListener('login-successful', function (event) {
            const mobile = event.detail.mobile;
            console.log('ورود با موفقیت انجام شد برای شماره:', mobile);

            // پنهان کردن فرم
            const form = document.getElementById('login-form');
            if (form) form.style.display = 'none';

            // نمایش پیام
            const message = document.getElementById('redirect-message');
            if (message) message.classList.remove('hidden');
            
        });
    </script>
@endpush

