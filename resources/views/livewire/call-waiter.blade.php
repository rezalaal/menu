<div
    @if($table && $table->called_waiter)
        wire:poll.10000ms="refreshTableStatus"
    @endif
>
    @if($table && !$table->called_waiter)
        <button
            wire:loading.remove
            wire:click="callWaiter"
            class="fixed flex items-center justify-center bottom-4 left-4 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 text-white p-3.5 shadow-lg hover:shadow-xl hover:scale-110 active:scale-95 transition-all duration-300 z-30 animate-pulse-glow">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512" class="h-6 w-6"><path d="M216 64c-13.3 0-24 10.7-24 24s10.7 24 24 24l16 0 0 33.3C119.6 157.2 32 252.4 32 368l448 0c0-115.6-87.6-210.8-200-222.7l0-33.3 16 0c13.3 0 24-10.7 24-24s-10.7-24-24-24l-40 0-40 0zM24 400c-13.3 0-24 10.7-24 24s10.7 24 24 24l464 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L24 400z"/></svg>
            <span wire:loading class="font-dastnevis text-xs mr-1">لطفا صبر کنید.</span>
        </button>

    @elseif($table && $table->called_waiter)
        <p wire:loading.remove class="fixed bottom-4 left-4 right-4 max-w-screen-sm mx-auto z-30 bg-white/90 backdrop-blur-lg rounded-2xl shadow-soft px-4 py-3 flex items-center gap-3 animate-fade-in-up border border-amber-200">
            <button wire:click="stopCallWaiter" class="flex-shrink-0 w-7 h-7 flex items-center justify-center rounded-full bg-red-50 text-red-400 hover:bg-red-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="4" y1="4" x2="20" y2="20"/>
                    <line x1="20" y1="4" x2="4" y2="20"/>
                </svg>
            </button>
            <span dir="rtl" class="font-iransans-thin text-sm text-coral-from/80">همکار ما تا لحظاتی دیگر در خدمت شما خواهد بود.</span>
        </p>
    @endif
</div>
