<form class="flex flex-col items-center justify-center w-full max-w-sm mx-auto space-y-4" wire:submit="SendOtp">
    <div dir="rtl" class="text-red-400 text-sm text-center font-iransans-thin">@error('mobile') {{ $message }} @enderror</div>

    <div class="w-full">
        <input
            wire:loading.remove
            wire:model="mobile"
            class="input-coral text-center farsi-number"
            dir="rtl"
            type="tel"
            inputmode="numeric"
            minlength="11"
            maxlength="11"
            placeholder="شماره تلفن همراه">
    </div>

    <button
        wire:loading.remove
        class="btn-secondary w-full py-3 rounded-2xl text-sm"
    >
        ورود
    </button>

    <a href="/" class="btn-outline w-full py-3 rounded-2xl text-sm text-center block">
        مشاهده منو بدون ثبت نام
    </a>

    <span wire:loading class="btn-secondary w-full py-3 rounded-2xl text-sm text-center opacity-70 cursor-not-allowed">
        در حال ارسال کد
    </span>
</form>
