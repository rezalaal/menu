<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-screen pb-16 flex flex-col md:items-center">
    <h1 class="font-dastnevis text-2xl mt-4 px-4 text-white">
        <a href="/products/<?php echo e($product->category->id); ?>"><?php echo e($product->category->name); ?></a>
        ::<?php echo e($product->name); ?>

    </h1>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('search-input', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1174044069-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('category-scroll-list', ['categoryId' => $product->category->id]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1174044069-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col justify-center mx-4">
        <!--[if BLOCK]><![endif]--><?php if($product->getFirstMediaUrl() == null): ?>
            <div class="aspect-[16/9] overflow-hidden">
                <img
                    class="w-full h-full object-cover object-center"
                    src="<?php echo e(config('app.url').'/images/category.jpg'); ?>"
                    alt="Product Picture">
            </div>
        <?php else: ?>
            <div class="aspect-[16/9] overflow-hidden">
                <img
                    class="w-full h-full object-cover object-center"
                    src="<?php echo e($product->getFirstMediaUrl()); ?>"
                    alt="Product Picture">
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <div class="m-4">
                <h3 class="text-xl font-dastnevis text-lime-900 pt-4 text-center"><?php echo e($product->name); ?></h3>
                <?php
                    use Illuminate\Support\Str;
                ?>

                <div class="prose max-w-none">
                    <?php echo Str::markdown($product->description); ?>

                </div>






                <div class="flex justify-between items-center pt-4 text-lime-800 text-lg font-dastnevis">
                    <span>قیمت:</span>
                    <span class="farsi-number"><?php echo e(number_format($product->price)); ?> تومان</span>
                </div>

                <div class="mt-4">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('add-to-cart-button', ['product' => $product]);

$__html = app('livewire')->mount($__name, $__params, 'lw-1174044069-2', $__slots ?? [], get_defined_vars());

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
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('footer-menu', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1174044069-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/product-view.blade.php ENDPATH**/ ?>