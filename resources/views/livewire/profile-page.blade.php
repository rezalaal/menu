<div dir="rtl" class="bg-coral-body min-h-screen pb-48 flex flex-col items-center">
    <h1 class="font-iransans-bold  text-coral text-xl mt-10 ">پروفایل</h1>

    @if ($showNamePrompt)
        <div class="w-full bg-body rounded shadow p-4 my-4 text-center">
            <p class="text-coral font-iransans-regular mb-2">
                سلام عزیز خوشحال میشیم اسمتو بدونیم
            </p>
            <input type="text" wire:model.defer="realName" class="border rounded px-2 py-1 w-full my-2" placeholder="اسم شما؟">
            <button wire:click="saveName" class="w-full bg-coral text-white px-4 py-2 rounded shadow">
                ذخیره
            </button>
            @error('realName')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    @else
        <p class="font-iransans-extrabold text-coral text-3xl">{{ $realName }}</p>
    @endif

    <livewire:back to="/?page=menu"/>
    <div class="bg-body w-full rounded-xl shadow-lg p-4 m-4 flex flex-col items-center">


        @if (auth()->user())
            <span class="farsi-number text-center text-2xl sm:text-3xl font-bold text-coral mt-2 font-iransans-bold">
                {{ auth()?->user()->username }}
            </span>
            <button wire:click="orders" class="mt-4 text-lg bg-coral text-white font-iransans-bold w-full px-6 py-2 rounded shadow hover:bg-lime-100 transition">
                سفارشات
            </button>
            <button wire:click="logoff" class="mt-4 text-lg bg-coral text-white font-iransans-bold w-full px-6 py-2 rounded shadow hover:bg-lime-100 transition">
                خروج
            </button>
        @else
            <livewire:login-form />
        @endif
    </div>

</div>
