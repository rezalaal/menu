<form class="flex flex-col mb-10 items-center justify-center" wire:submit="verify">
    <div class="text-red-900 text-center p-2 font-iransans-thin text-sm">
        @error('otp') {{ $message }} @enderror
    </div>

    <input
        wire:model="otp"
        class="flex justify-center items-center no-spinner placeholder-lime-900 font-iransans-thin bg-gray-100 w-80 text-sm text-center outline-0 px-4 py-2 shadow-2xl text-lime-900"
        dir="rtl"
        type="number"
        inputmode="numeric"
        minlength="5"
        maxlength="5"
        placeholder="کد تایید ۵ رقمی">

    <button
        wire:loading.remove
        class="flex justify-center items-center border-1 font-iransans-thin bg-coral w-80 px-4 py-2 mt-2 shadow-2xl hover:bg-gray-200 text-lime-100 text-sm"
    >
        تایید
    </button>

    <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
</form>
