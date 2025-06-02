<div class="relative mx-4 md:px-4 mt-4">

    <input wire:model.live="search" class="border-1 font-dastnevis placeholder-lime-900 border-lime-950 rounded-lg bg-white w-full text-xl outline-0 px-4 py-2 shadow-2xl text-lime-800" type="search" placeholder="جستجو">
    <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
    <!--[if BLOCK]><![endif]--><?php if($products): ?>

        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="mt-4 pb-4 px-4 bg-lime-100 rounded-3xl">
            <div class="relative top-50 flex flex-cols gap-4 items-center">
                <div class="mt-4 cursor-pointer">
                    <!--[if BLOCK]><![endif]--><?php if($product->getFirstMediaUrl() == null): ?>
                        <a href="/product/<?php echo e($product->id); ?>" wire:navigate>
                            <img class=" rounded-xl w-36 h-36 object-center aspect-[1/1] shadow-2xl" src="<?php echo e(config('app.url').'/images/category.jpg'); ?>" alt="Product Picture">
                        </a>
                    <?php else: ?>
                        <a href="/product/<?php echo e($product->id); ?>" wire:navigate>
                            <img class=" rounded-xl w-36 h-36 object-center aspect-[1/1] shadow-2xl" src="<?php echo e($product->getFirstMediaUrl()); ?>" alt="Product Picture">
                        </a>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <a href="/product/<?php echo e($product->id); ?>" wire:navigate>
                        <h3 class="text-xl text-right font-dastnevis pt-1"><?php echo e($product->name); ?></h3>
                    </a>
                    <div class="flex justify-around p-2 text-xl font-iransans-bold text-lime-800">
                        <span class="farsi-number"><?php echo e(number_format($product->price)); ?></span>
                        <span class="font-dastnevis px-4">تومان</span>
                    </div>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('add-to-cart-button', ['product' => $product]);

$__html = app('livewire')->mount($__name, $__params, 'lw-4204009113-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/search-input.blade.php ENDPATH**/ ?>