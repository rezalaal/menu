<div class="p-4 text-white">
<span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div wire:click="order(<?php echo e($order->id); ?>)" class="cursor-pointer flex flex-col p-4 gap-2 text-2xl bg-lime-100 mt-4 text-lime-950 font-dastnevis rounded-2xl shadow-xl">
            <div class="flex flex-row justify-between items-center">
                <span>تاریخ</span>
                <span><?php echo e(verta($order->created_at)->format("Y/m/d")); ?></span>
            </div>
            <div class="flex flex-row justify-between items-center">
                <span>ساعت</span>
                <span><?php echo e(verta($order->created_at)->format("H:i")); ?></span>
            </div>
            <div class="flex flex-row justify-between items-center">
                <span>جمع مبلغ</span>
                <span><?php echo e(number_format($order->total)); ?> تومان</span>
            </div>
            <div class="flex flex-row justify-between items-center">
                <span>وضعیت</span>
                <span><?php echo e($order->status); ?></span>
            </div>
            <div class="flex flex-row justify-between items-center">
                <span>میز</span>
                <span><?php echo e($order->table->name); ?></span>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/current-orders.blade.php ENDPATH**/ ?>