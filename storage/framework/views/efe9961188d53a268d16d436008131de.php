<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-full pb-48 flex flex-col md:items-center">
    <h1 class="font-dastnevis font-black text-3xl mt-10 px-4 text-white"><?php echo e($categoryName); ?></h1>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('search-input', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3080600434-0', $__slots ?? [], get_defined_vars());

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
[$__name, $__params] = $__split('category-scroll-list', ['categoryId' => $categoryId]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3080600434-1', $__slots ?? [], get_defined_vars());

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
[$__name, $__params] = $__split('product-list', ['category' => $categoryId]);

$__html = app('livewire')->mount($__name, $__params, 'lw-3080600434-2', $__slots ?? [], get_defined_vars());

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
[$__name, $__params] = $__split('footer-menu', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3080600434-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/products-page.blade.php ENDPATH**/ ?>