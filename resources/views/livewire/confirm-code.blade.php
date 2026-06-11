<form class="flex flex-col items-center justify-center w-full max-w-sm mx-auto space-y-4" wire:submit="verify">
    @if ($step == "confirmCode")
        <div dir="rtl" class="text-coral-from text-sm text-center font-iransans-thin bg-coral/10 rounded-2xl px-4 py-3">
            یک کد ۵ رقمی به تلفن همراه شما ارسال شد
        </div>

        <div class="w-full">
            <input
                wire:loading.remove
                wire:model="otp"
                class="input-coral text-center farsi-number text-2xl tracking-[0.5em]"
                dir="rtl"
                type="number"
                inputmode="numeric"
                minlength="5"
                maxlength="5"
                placeholder="—— — — —">
        </div>

        <div class="w-full">
            <button
                wire:loading.remove
                class="btn-secondary w-full py-3 rounded-2xl text-sm"
            >
                تایید
            </button>
        </div>

        <span wire:loading class="btn-secondary w-full py-3 rounded-2xl text-sm text-center opacity-70 cursor-not-allowed">
            در حال بررسی
        </span>
    @endif
</form>
