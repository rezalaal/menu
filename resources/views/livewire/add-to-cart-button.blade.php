<div class="-z-50">
    @if($loggedIn)
        @if ($onCartItems)
            <div wire:loading.remove class="flex justify-center items-center mt-4">
                <button wire:click="increase" wire:loading.remove class="bg-white shadow-sm shadow-lime-400 hover:shadow-lime-600 rounded-full text-3xl font-black text-lime-950 w-10 h-10 ">+</button>
                <span class="font-iransans-extrabold farsi-number text-lime-900 text-2xl mx-2 font-black">{{ $qty }}</span>
                <button wire:click="decrease" wire:loading.remove class="bg-white shadow-sm shadow-lime-400 hover:shadow-lime-600 rounded-full text-3xl font-black text-lime-950 w-10 h-10 ">-</button>
            </div>
            <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
        @else
            <button wire:click="add" wire:loading.remove class="bg-white shadow-sm shadow-lime-400 hover:shadow-lime-600 w-full rounded-xl font-dastnevis text-2xl text-lime-950 pt-2  mt-4">انتخاب</button>
            <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
        @endif 
    @endif           
</div>
