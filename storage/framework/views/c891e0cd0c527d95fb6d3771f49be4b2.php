<div class="mt-4 px-4 pb-96 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6  gap-6">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="mt-4 cursor-pointer">
            <!--[if BLOCK]><![endif]--><?php if($product->getFirstMediaUrl() == null): ?>
                <a href="/product/<?php echo e($product->id); ?>" wire:navigate>
                    <img class=" rounded-3xl shadow-lg  object-center aspect-[1/1]" src="<?php echo e(config('app.url').'/images/category.jpg'); ?>" alt="Product Picture">    
                </a>
            <?php else: ?>
                <a href="/product/<?php echo e($product->id); ?>" wire:navigate>
                    <img class=" rounded-3xl shadow-lg  object-center aspect-[1/1]" src="<?php echo e($product->getFirstMediaUrl()); ?>" alt="Product Picture">    
                </a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->            
            <a href="/product/<?php echo e($product->id); ?>" wire:navigate>
                <h3 class="text-2xl text-center font-dastnevis pt-4"><?php echo e($product->name); ?></h3>
            </a>
            <div class="flex justify-evenly p-2 text-2xl font-iransans-bold text-lime-800">
                <span class="farsi-number"><?php echo e(number_format($product->price)); ?></span>
                <span class="font-dastnevis">تومان</span>
            </div>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('add-to-cart-button', ['product' => $product]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2344138063-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/product-list.blade.php ENDPATH**/ ?>