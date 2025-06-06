<div class="flex justify-center my-4">
    <button wire:click="call"
            class="bg-red-600 hover:bg-red-700 text-white font-dastnevis px-6 py-3 rounded-xl shadow-xl text-xl">
        صدا زدن گارسون
    </button>

    <script>
        window.addEventListener('alert', event => {
            alert(event.detail.message);
        });
    </script>
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/call-waiter.blade.php ENDPATH**/ ?>