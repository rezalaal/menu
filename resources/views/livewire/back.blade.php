<div class="fixed top-4 right-4 z-50 cursor-pointer" wire:click="goBack">
    <div wire:loading.remove class="w-10 h-10 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm text-coral-from shadow-soft hover:bg-coral hover:text-white hover:shadow-glow transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </div>
    <div wire:loading class="w-10 h-10 flex items-center justify-center">
        <svg class="animate-spin w-5 h-5 text-coral-from" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</div>
