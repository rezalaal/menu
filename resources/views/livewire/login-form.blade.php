<form class="flex flex-col mb-10 items-center justify-center"  wire:submit="SendOtp">
    <div class="text-red-900 text-center p-4 font-iransans-thin">@error('mobile') {{ $message }} @enderror</div>
    <input
        wire:loading.remove
        wire:model="mobile"
        class="farsi-number placeholder:font-iransans-thin flex justify-center items-center no-spinner placeholder-lime-900 font-iransans-extrabold bg-gray-100 w-80 text-right text-sm text-center outline-0 px-4 py-2 shadow-2xl text-lime-900"
        dir="rtl"
        type="number"
        inputmode="numeric"
        minlength="11"
        maxlength="11"
        placeholder="شماره تلفن همراه">

    <button
        wire:loading.remove
        class="flex justify-center items-center border-1 font-iransans-thin bg-coral w-80 px-4  py-2 mt-2 shadow-2xl hover:bg-gray-200 text-white hover:text-black text-sm"
    >
    ورود
    </button>
    <span wire:loading class="loading text-center mt-2 loading-dots loading-lg px-4 py-1 w-full text-white bg-coral font-iransans-thin">در حال ارسال کد</span>
</form>
