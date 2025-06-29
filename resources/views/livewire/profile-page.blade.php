<div dir="rtl" class="bg-coral-body min-h-screen pb-48 flex flex-col items-center px-4 sm:px-0">
    <h1 class="font-iransans-bold text-coral text-xl mt-10">پروفایل</h1>

    @if ($showNamePrompt)
        <div class="w-full max-w-md bg-body rounded shadow p-6 my-4 text-center">
            <p class="text-coral font-iransans-regular mb-4">
                سلام عزیز، خوشحال می‌شیم اسمتو بدونیم
            </p>
            <label for="realNameInput" class="sr-only">اسم شما</label>
            <input 
                id="realNameInput"
                type="text" 
                wire:model.defer="realName" 
                class="text-right font-iransans-thin border rounded px-3 py-2 w-full mb-3 focus:outline-none focus:ring-2 focus:ring-coral" 
                placeholder="اسم شما؟"
                aria-required="true"
            >
            <button 
                wire:click="saveName" 
                class="w-full font-iransans-bold bg-coral text-white px-4 py-2 rounded shadow hover:bg-coral-dark transition focus:outline-none focus:ring-4 focus:ring-coral"
                aria-label="ذخیره نام"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>ذخیره</span>
                <span wire:loading>در حال ذخیره...</span>
            </button>
            @error('realName')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>
    @else
        <p class="font-iransans-extrabold text-coral text-3xl mt-6">{{ $realName }}</p>
    @endif

    <livewire:back to="/?page=menu"/>

    <div class="bg-body w-full max-w-md rounded-xl shadow-lg p-6 m-4 flex flex-col items-center">
        @if (auth()->user())
            <span 
                class="farsi-number text-center text-2xl sm:text-3xl font-bold text-coral mt-2 font-iransans-bold"
                aria-label="نام کاربری"
            >
                {{ auth()?->user()->username }}
            </span>

            <button 
                wire:click="orders" 
                class="mt-6 text-lg bg-coral text-white font-iransans-bold w-full px-6 py-3 rounded shadow hover:bg-lime-100 hover:text-coral transition focus:outline-none focus:ring-4 focus:ring-coral"
                aria-label="مشاهده سفارشات"
            >
                سفارشات
            </button>

            <button 
                wire:click="logoff" 
                class="mt-4 text-lg bg-coral text-white font-iransans-bold w-full px-6 py-3 rounded shadow hover:bg-lime-100 hover:text-coral transition focus:outline-none focus:ring-4 focus:ring-coral"
                aria-label="خروج از حساب کاربری"
            >
                خروج
            </button>
        @else
            <livewire:login-form />
        @endif
    </div>
</div>
