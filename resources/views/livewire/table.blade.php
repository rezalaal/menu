<div class="font-iransans-regular bg-gradient-to-b from-coral-from to-coral-to min-h-screen flex flex-col justify-center items-center p-6 gap-10">
    <!-- تصویر و عنوان -->
    <div class="flex flex-col items-center ">
        <img class="rounded-full w-56 h-56 shadow-2xl" src="{{ $tableImageUrl }}" alt="plate of food">

        <span class="font-mallanna text-4xl pt-6 text-shadow gradient-text animate-gradient text-center">
         {{ $settings['title'] }}
      </span>

        <span class="pt-4 text-white font-dastnevis text-xl text-center" dir="rtl">
         {{ $tableName }}
      </span>
    </div>

    <!-- فرم ورود / تایید شماره -->
    <div class="flex flex-col items-center">
        <form class="flex flex-col w-full max-w-xs" wire:submit="login">
            <div class="text-red-900 text-center p-2">@error('mobile') {{ $message }} @enderror</div>

            @if ($loggedIn)
                <div class="text-center text-2xl text-lime-800 font-iransans-extrabold">
                    @auth
                        <span class="farsi-number">{{ auth()->user()->username }}</span>
                    @endauth
                    <p class="text-lg text-lime-950 farsi-number p-4 cursor-pointer font-dastnevis" wire:click="logoff">شماره من نیست</p>
                </div>
            @else
                <input wire:model="mobile"
                       type="number"
                       dir="rtl"
                       placeholder="شماره تلفن همراه"
                       class="placeholder-lime-900 font-dastnevis rounded-xl bg-gray-100 w-full text-xl text-center outline-0 p-4 shadow-2xl text-lime-900">
            @endif

            <button wire:loading.remove class="border font-dastnevis rounded-xl bg-gray-100 w-full pt-2 pb-1 mt-4 shadow-2xl hover:bg-gray-200 text-lime-900 text-xl">
                ثبت سفارش
            </button>

            <span wire:loading class="loading loading-dots loading-lg pt-4 text-white"></span>
        </form>
    </div>

    <!-- اطلاعات تماس -->
    <div class="w-full flex justify-around text-white mt-10 text-sm flex-wrap gap-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 mx-1" viewBox="0 0 50 50">...</svg>
            <span class="font-iransans-ultralight">{{ $settings['instagram'] }}</span>
        </div>
        <div class="flex items-center">
            <svg class="w-5 h-5 mx-1" viewBox="0 0 50 50">...</svg>
            <span class="font-iransans-ultralight">{{ $settings['mobile'] }}</span>
        </div>
    </div>
</div>
