<div class="relative mt-4 w-full px-4">

    <input wire:model.live="search" class="border-1 font-dastnevis placeholder-lime-900 border-lime-950 rounded-lg bg-[#ECFAE5] w-full text-xl outline-0 px-4 py-2 shadow-2xl text-lime-800" type="search" placeholder="جستجو">
    <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
    <!--[if BLOCK]><![endif]--><?php if($products): ?>

        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mt-4 pb-4 px-4 bg-lime-100 rounded-3xl shadow-md">
                <div class="grid grid-cols-[auto_1fr] gap-4 items-start">
                    <a href="/product/<?php echo e($product->id); ?>" wire:navigate class="block mt-2">
                        <img
                            class="rounded-2xl w-28 h-28 object-cover shadow-lg"
                            src="<?php echo e($product->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg'); ?>"
                            alt="Product Picture"
                        >
                    </a>

                    <div class="flex flex-col justify-between h-full pt-2">
                        <a href="/product/<?php echo e($product->id); ?>" wire:navigate>
                            <h3 class="text-right font-dastnevis text-xl text-lime-950 leading-snug mt-1">
                                <?php echo e($product->name); ?>

                            </h3>
                        </a>

                        <div class="flex justify-between items-center mt-3">
                            <div class="text-lime-800 font-iransans-bold text-lg">
                                <span class="farsi-number"><?php echo e(number_format($product->price)); ?></span>
                                <span class="font-dastnevis ml-1">تومان</span>
                            </div>
                        </div>

                        <div class="mt-4">
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
            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/search-input.blade.php ENDPATH**/ ?>