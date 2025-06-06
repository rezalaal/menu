<div class="z-10 w-full max-w-sm mx-auto px-4">
    <!--[if BLOCK]><![endif]--><?php if($loggedIn): ?>
        <!--[if BLOCK]><![endif]--><?php if($onCartItems): ?>
            <div wire:loading.remove class="grid grid-cols-3 gap-2 mt-4 items-center text-center">
                <button wire:click="increase"
                        class="bg-lime-600 hover:bg-lime-700 text-white text-xl font-dastnevis py-2 rounded-xl shadow-lg transition duration-200">
                    +
                </button>

                <span class="font-iransans-bold farsi-number text-lime-900 text-2xl">
                    <?php echo e($qty); ?>

                </span>

                <button wire:click="decrease"
                        class="bg-yellow-200 hover:bg-yellow-300 text-lime-950 text-xl font-dastnevis py-2 rounded-xl shadow-lg transition duration-200">
                    -
                </button>

            </div>

            <span wire:loading class="block text-center pt-2 text-sm text-gray-600">در حال بروزرسانی...</span>

        <?php else: ?>
            <button wire:click="add"
                    class="w-full bg-lime-600 hover:bg-lime-700 text-white text-xl font-dastnevis py-3 rounded-xl shadow-lg mt-4 transition duration-200">
                انتخاب
            </button>
            <span wire:loading class="block text-center pt-2 text-sm text-gray-600">در حال افزودن...</span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/add-to-cart-button.blade.php ENDPATH**/ ?>