<div dir="rtl" class="min-h-screen pb-32 flex flex-col items-center px-4">
    <div class="bg-gradient-brand rounded-b-3xl shadow-soft p-6 pt-8 w-full text-center">
        <h1 class="font-dastnevis text-2xl text-white text-shadow">پروفایل</h1>
    </div>

    <livewire:back to="/?page=menu"/>

    @if ($showNamePrompt)
        <div class="card-coral w-full max-w-md p-6 mt-6">
            <p class="text-coral-from font-iransans-thin text-sm mb-4 text-center">
                سلام عزیز، خوشحال می‌شیم اسمتو بدونیم
            </p>
            <input
                id="realNameInput"
                type="text"
                wire:model.defer="realName"
                class="input-coral mb-3"
                placeholder="اسم شما؟"
            >
            <button
                wire:click="saveName"
                class="btn-secondary w-full py-2.5 rounded-xl text-sm"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>ذخیره</span>
                <span wire:loading>در حال ذخیره...</span>
            </button>
            @error('realName')
                <p class="text-red-400 text-xs mt-2 font-iransans-thin">{{ $message }}</p>
            @enderror
        </div>
    @else
        <p class="font-dastnevis text-coral-from text-3xl mt-6">{{ $realName }}</p>
    @endif

    <div class="card-coral w-full max-w-md p-6 mt-6 space-y-4">
        @if (auth()->user())
            <div class="text-center">
                <span class="farsi-number text-2xl font-iransans-bold text-coral-from">
                    {{ auth()?->user()->username }}
                </span>
            </div>

            <button
                wire:click="orders"
                class="btn-secondary w-full py-3 rounded-2xl text-sm"
            >
                سفارشات
            </button>

            <button
                wire:click="logoff"
                class="btn-outline w-full py-3 rounded-2xl text-sm"
            >
                خروج
            </button>
        @else
            <livewire:login-form />
        @endif
    </div>
</div>
