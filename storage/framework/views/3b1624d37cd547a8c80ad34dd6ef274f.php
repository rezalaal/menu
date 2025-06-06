<div class="flex flex-col justify-center my-4">
    <button id="notifyWaiterBtn" wire:click="notifyWaiter"
            class="bg-red-600 hover:bg-red-700 text-white font-dastnevis px-6 py-3 rounded-xl shadow-xl text-xl">
        <span wire:loading.remove>صدا زدن گارسون</span>
        <span wire:loading>در حال صدا زدن </span>
    </button>

    <div id="waiter-modal"
         x-data="{ showModal: false, message: '' }"
         x-show="showModal"
         x-transition
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
         x-cloak
         <?php echo $__env->yieldSection(); ?>-waiter-modal.window="message = $event.detail.message; showModal = true"
    >
        <div class="bg-white rounded-2xl shadow-lg p-6 max-w-sm text-center">
            <h2 class="text-xl font-bold mb-4 text-gray-800">📢 پیام</h2>
            <p class="text-gray-700 mb-6" x-text="message"></p>
            <button @click="showModal = false"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                بستن
            </button>
        </div>
    </div>

    <div x-data="{ msg: 'سلام از Alpine' }">
        <button @click="alert(msg)">تست Alpine</button>
    </div>

    <script>
        window.addEventListener('alert', event => {
            window.dispatchEvent(new CustomEvent('show-waiter-modal', {
                detail: {
                    message: event.detail.message
                }
            }));
        });
    </script>

</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/call-waiter.blade.php ENDPATH**/ ?>