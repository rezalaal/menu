<div class="fixed top-4 left-4 z-50 cursor-pointer" wire:click="goBack">
    <svg wire:loading.remove xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-coral hover:text-orange-500 transition"
        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
    <div wire:loading class="w-8 h-8 text-coral">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
        <circle
        cx="50"
        cy="50"
        r="40"
        stroke="#ff5722"
        stroke-width="10"
        fill="none"
        stroke-linecap="round"
        stroke-dasharray="62.8 188.4"
        >
        <animateTransform
            attributeName="transform"
            type="rotate"
            from="0 50 50"
            to="360 50 50"
            dur="1s"
            repeatCount="indefinite"
        />
        </circle>
    </svg>
    </div>

</div>
