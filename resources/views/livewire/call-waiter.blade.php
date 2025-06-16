<div class="flex flex-col items-center justify-center mt-6"
    @if($table && $table->called_waiter)
        wire:poll.10000ms="refreshTableStatus"
    @endif
>
    @if($table && !$table->called_waiter)
        <!-- دکمه صدا زدن گارسون -->
        <button
            wire:loading.remove
            wire:click="callWaiter"
            class="fixed flex justify-center items-center bottom-4 left-0 bg-coral text-white p-3 rounded-br-xl shadow-lg hover:bg-orange-500 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512" class="h-6 w-6 text-white"><path d="M216 64c-13.3 0-24 10.7-24 24s10.7 24 24 24l16 0 0 33.3C119.6 157.2 32 252.4 32 368l448 0c0-115.6-87.6-210.8-200-222.7l0-33.3 16 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0-40 0zM24 400c-13.3 0-24 10.7-24 24s10.7 24 24 24l464 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L24 400z"/></svg>
            <span wire:loading class="font-dastnevis">لطفا صبر کنید.</span>
        </button>

    @elseif($table && $table->called_waiter)
        <p class="fixed bottom-9 left-0 bg-coral/80 text-white text-sm md:text-base font-iransans rounded-tr-lg rounded-br-lg px-4 py-1 shadow-xl flex items-center gap-2 animate-fade-in transition-all duration-300">
            <span class="text-lg" wire:click="stopCallWaiter" role="button" style="cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512" class="h-4 w-4 text-white"><path d="M216 64c-13.3 0-24 10.7-24 24s10.7 24 24 24l16 0 0 33.3C119.6 157.2 32 252.4 32 368l448 0c0-115.6-87.6-210.8-200-222.7l0-33.3 16 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0-40 0zM24 400c-13.3 0-24 10.7-24 24s10.7 24 24 24l464 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L24 400z"/></svg>
            </span>
            <span dir="rtl">همکار ما تا لحظاتی دیگر در خدمت شما خواهد بود.</span>
        </p>
    @endif
</div>
