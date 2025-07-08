<form class="flex flex-col mb-10 items-center justify-center" wire:submit="verify">
    <div class="text-coral text-center p-2 font-iransans-thin text-sm">
        @error('otp') {{ $message }} @enderror
    </div>
    @if ($step == "confirmCode")
    <div dir="rtl" class="text-red-900 text-center div-4 font-iransans-black">یک کد ۵ رقمی به تلفن همراه شما ارسال شد</div>
    <input
        wire:loading.remove
        wire:model="otp"
        class="flex justify-center items-center no-spinner placeholder-lime-900 farsi-number placeholder:font-iransans-thin font-iransans-extrabold bg-gray-100 w-80 text-right text-sm text-center outline-0 px-4 py-2 shadow-2xl text-lime-900"
        dir="rtl"
        type="number"
        inputmode="numeric"
        minlength="5"
        maxlength="5"
        placeholder="کد تایید ۵ رقمی">

    <button
        wire:loading.remove
        class="flex justify-center items-center border-1 font-iransans-thin bg-coral w-80 px-4 py-2 mt-2 shadow-2xl hover:bg-gray-200 text-lime-100 hover:text-black text-sm"
    >
        تایید
    </button>

    <span wire:loading class="loading text-center mt-2 loading-dots loading-lg px-4 py-1 w-full text-white bg-coral font-iransans-thin">در حال بررسی</span>

    @endif
</form>
