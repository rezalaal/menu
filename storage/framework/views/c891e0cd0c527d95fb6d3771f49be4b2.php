<div class="mt-4 px-4 pb-96 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col justify-between">
            <!-- تصویر محصول با نسبت 16:9 -->
            <a href="/product/<?php echo e($product->id); ?>" wire:navigate>
                <div class="aspect-[16/9] overflow-hidden">
                    <img
                        class="w-full h-full object-cover object-center"
                        src="<?php echo e($product->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg'); ?>"
                        alt="Product Picture"
                    >
                </div>
            </a>

            <!-- محتوای کارت -->
            <div class="p-3 flex flex-col justify-between flex-1">
                <!-- نام محصول -->
                <a href="/product/<?php echo e($product->id); ?>" wire:navigate>
                    <h3 class="text-center text-lime-900 font-dastnevis text-lg leading-snug pt-2">
                        <?php echo e($product->name); ?>

                    </h3>
                </a>

                <!-- قیمت -->
                <div class="flex justify-between items-center text-sm font-iransans-bold text-lime-700 mt-2">
                    <span class="farsi-number"><?php echo e(number_format($product->price)); ?></span>
                    <span class="font-dastnevis">تومان</span>
                </div>

                <!-- دکمه افزودن به سبد -->
                <div class="mt-2">
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
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/product-list.blade.php ENDPATH**/ ?>