<div class="mt-4 px-4 grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7  gap-6">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="mt-4 cursor-pointer ">
            <!--[if BLOCK]><![endif]--><?php if($category->getFirstMediaUrl() == null): ?>
                <a href="/products/<?php echo e($category->id); ?>" wire:navigate>
                    <img class="rounded-full w-28 h-28 md:w-60 md:h-60" src="<?php echo e(config('app.url').'/images/category.jpg'); ?>" alt="Menu Picture">    
                </a>
            <?php else: ?>
                <a href="/products/<?php echo e($category->id); ?>" wire:navigate>
                    <img class="rounded-full w-28 h-28 md:w-60 md:h-60" src="<?php echo e($category->getFirstMediaUrl()); ?>" alt="Menu Picture">    
                </a>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            
            <a href="/products/<?php echo e($category->id); ?>" wire:navigate>
                <h3 class="text-center text-lime-950 font-dastnevis pt-4"><?php echo e($category->name); ?></h3>
            </a>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/category-list.blade.php ENDPATH**/ ?>