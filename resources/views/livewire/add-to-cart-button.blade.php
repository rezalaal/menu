<div class="z-10 w-full max-w-sm mx-auto">
    @if($loggedIn)
        @if ($onCartItems)
            <div wire:loading.remove class="flex items-center justify-center gap-2 mt-2">
                <button wire:click="increase"
                    class="w-8 h-8 flex items-center justify-center bg-coral text-white rounded-lg hover:bg-coral-from transition text-sm font-iransans-bold shadow-soft active:scale-95">
                    +
                </button>
                <span class="min-w-[20px] text-center font-iransans-bold text-sm farsi-number text-coral-from">
                    {{ $qty }}
                </span>
                <button wire:click="decrease"
                    class="w-8 h-8 flex items-center justify-center bg-coral/20 text-coral-from rounded-lg hover:bg-coral hover:text-white transition text-sm active:scale-95">
                    −
                </button>
            </div>
            <span wire:loading class="block text-center text-xs text-coral-from/50 font-iransans-thin animate-pulse">در حال بروزرسانی...</span>
        @else
            <button wire:click="add"
                class="w-full bg-coral hover:bg-coral-from text-white text-sm font-iransans-thin py-2 rounded-xl shadow-soft transition-all duration-300 active:scale-95">
                افزودن به سفارش
            </button>
            <span wire:loading class="block text-center text-xs text-coral-from/50 font-iransans-thin mt-1 animate-pulse">در حال افزودن...</span>
        @endif
    @endif
</div>
