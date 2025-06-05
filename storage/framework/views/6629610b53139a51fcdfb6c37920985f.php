<div dir="rtl" class="px-2 bg-gradient-to-b from-coral-from to-coral-to h-full pb-48 flex flex-col md:items-center">
        <h1 class="font-dastnevis text-3xl font-black mt-10 px-4 text-white">سفارشات </h1>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('search-input', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1064157814-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    <div class="mt-4 text-white font-dastnevis text-sm flex flex-row justify-center items-center">
        <button class="px-6 rounded-t-xl <?php if($tab == 'previous'): ?> bg-lime-950 border-b-lime-400 border-b-4 pb-1 <?php else: ?> bg-lime-900 pb-2 <?php endif; ?> " wire:click="switch('prev')">سفارشات پیشین</button>
        <button class="px-6 rounded-t-xl <?php if($tab == 'current'): ?> bg-lime-950 border-b-lime-400 border-b-4 pb-1 <?php else: ?> bg-lime-900  pb-2 <?php endif; ?>" wire:click="switch('curr')">سفارشات جاری</button>
    </div>
    <div class="w-full flex flex-col bg-lime-950 rounded-3xl pb-36">
    <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>

        <!--[if BLOCK]><![endif]--><?php if($tab == "current"): ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('current-orders', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1064157814-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <?php else: ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('previous-orders', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1064157814-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('footer-menu', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-1064157814-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/order-page.blade.php ENDPATH**/ ?>