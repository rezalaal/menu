
<div class="font-iransans-regular bg-gradient-to-b from-coral-from to-coral-to min-h-screen flex flex-col justify-between items-center p-6">
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
    <div class="flex flex-col items-center w-full mt-2 font-dastnevis">
        <form class="flex flex-col w-full max-w-sm bg-white/90 rounded-xl shadow-inner p-6 backdrop-blur-lg" wire:submit="login">
            <div class="text-red-900 text-center p-2">@error('mobile') {{ $message }} @enderror</div>

            @if ($loggedIn)
                <div class="text-center text-2xl text-lime-800 font-iransans-extrabold">
                    @auth
                        <span class="farsi-number">{{ auth()->user()->username }}</span>
                    @endauth
                </div>
                <p class="text-sm text-lime-950 farsi-number pt-4 cursor-pointer font-dastnevis hover:underline text-center"
                    wire:click="logoff">
                    ورود با شماره دیگر
                </p>
                <button wire:loading.remove
                        class="relative border font-dastnevis rounded-xl bg-lime-700 hover:bg-lime-800 text-white w-full pt-2 pb-1 mt-4 shadow-xl text-xl transition-all duration-300"
                        wire:loading.attr="disabled">
                    ثبت سفارش
                    <span wire:loading class="absolute left-4 top-1/2 transform -translate-y-1/2 loading loading-spinner loading-xs"></span>
                </button>
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
        <div wire:loading>
            <livewire:placeholder>
        </div>
    </div>

    <!-- اطلاعات تماس -->
    <div class="w-full flex justify-around text-white text-sm flex-wrap gap-6 mt-4 mb-4">
        <a href="https://instagram.com/{{ $settings['instagram'] }}" target="_blank" class="flex items-center hover:text-pink-200 transition-all">
            <svg class="w-6 h-6 mx-2 fill-current" viewBox="0 0 24 24">
                <path d="..."/>
            </svg>
            <span class="font-iransans-ultralight underline">{{ '@' . $settings['instagram'] }}</span>
        </a>

        <a href="tel:{{ $settings['mobile'] }}" class="flex items-center hover:text-green-200 transition-all">
            <svg class="w-6 h-6 mx-2 fill-current" viewBox="0 0 24 24">
                <path d="..."/>
            </svg>
            <span class="font-iransans-ultralight underline farsi-number">{{ $settings['mobile'] }}</span>
        </a>
    </div>
</div>
