<form class="flex flex-col mb-10 items-center justify-center"  wire:submit="login">
    <div class="text-red-900 text-center p-4 font-dastnevis"><!--[if BLOCK]><![endif]--><?php $__errorArgs = ['mobile'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]--></div>

    <input wire:model="mobile" class="no-spinner placeholder-lime-900 font-dastnevis rounded-xl bg-gray-100 w-80  text-2xl text-center outline-0 p-4 pt-4 shadow-2xl text-lime-900" dir="rtl" type="number" placeholder="شماره تلفن همراه">

    <button wire:loading.remove class="border-1 font-dastnevis rounded-xl bg-gray-100 w-80 p-4  pt-4 mt-2 shadow-2xl hover:bg-gray-200 text-lime-900 text-xl">
    ورود
    </button>
    <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
</form>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/login-form.blade.php ENDPATH**/ ?>