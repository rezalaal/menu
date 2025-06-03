<div class="-z-50">
    <!--[if BLOCK]><![endif]--><?php if($loggedIn): ?>
        <!--[if BLOCK]><![endif]--><?php if($onCartItems): ?>
            <div wire:loading.remove class="flex justify-center items-center mt-4">
                <button wire:click="increase" wire:loading.remove class="w-full text-center bg-lime-100 hover:bg-lime-200 text-lime-900 font-dastnevis py-2 px-4 rounded-xl shadow">+</button>
                <span class="font-iransans-extrabold farsi-number text-lime-900 text-2xl mx-2 font-black"><?php echo e($qty); ?></span>
                <button wire:click="decrease" wire:loading.remove class="w-full text-center bg-lime-100 hover:bg-lime-200 text-lime-900 font-dastnevis py-2 px-4 rounded-xl shadow ">-</button>
            </div>
            <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
        <?php else: ?>
            <button wire:click="add" wire:loading.remove class="w-full text-center bg-lime-100 hover:bg-lime-200 text-lime-900 font-dastnevis py-2 px-4 rounded-xl shadow">انتخاب</button>
            <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/add-to-cart-button.blade.php ENDPATH**/ ?>