<div class="z-10 w-full max-w-sm mx-auto px-4">
    @if($loggedIn)
        @if ($onCartItems)
            <div wire:loading.remove class="grid grid-cols-3 gap-2 mt-4 items-center text-center">
                <button wire:click="increase"
                        class="bg-lime-600 hover:bg-lime-700 text-white text-xl font-dastnevis py-3 rounded-xl shadow-lg transition duration-200 touch-manipulation">
                    +
                </button>

                <span class="font-iransans-bold farsi-number text-lime-900 text-2xl">
                    {{ $qty }}
                </span>

                <button wire:click="decrease"
                        class="bg-yellow-200 hover:bg-yellow-300 text-lime-950 text-xl font-dastnevis py-3 rounded-xl shadow-lg transition duration-200 touch-manipulation">
                    -
                </button>
            </div>

            <span wire:loading class="block text-center pt-2 text-sm text-gray-600">در حال بروزرسانی...</span>

        @else
            <button wire:click="add"
                class="w-full bg-lime-600 hover:bg-lime-700 text-white text-base font-dastnevis py-2 rounded-lg shadow-md mt-4 transition duration-200">
                افزودن به سفارش
            </button>

            <span wire:loading class="block text-center pt-2 text-sm text-gray-600">در حال افزودن...</span>
        @endif   
    @endif
</div>