<div class="flex flex-col">
    <ul class="flex text-3xl scroll-smooth snap-start overflow-x-auto min-h-0 m-4 no-scrollbar">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!--[if BLOCK]><![endif]--><?php if($category->id == $categoryId): ?>
            <li wire:click="category(<?php echo e($category->id); ?>)" class="bg-lime-100  font-dastnevis text-black text-sm cursor-pointer px-4 py-2 rounded-xl shadow-md flex flex-row mx-2 whitespace-nowrap"><?php echo e($category->name); ?></li>
            <?php else: ?>
                <li wire:click="category(<?php echo e($category->id); ?>)" class="bg-lime-200  font-dastnevis text-black text-sm cursor-pointer px-4 py-2 rounded-xl shadow-md flex flex-row mx-2 whitespace-nowrap"><?php echo e($category->name); ?></li>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </ul>
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/category-scroll-list.blade.php ENDPATH**/ ?>