<div class="px-4 grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-5">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex flex-col items-center">
            <a href="/products/<?php echo e($category->id); ?>" wire:navigate>
                <div class="egg-container">
                    <div class="egg-shape" style="background-image: url('<?php echo e($category->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg'); ?>')">
                    </div>
                </div>
            </a>
            <a href="/products/<?php echo e($category->id); ?>" wire:navigate>
                <h3 class="-mt-4 text-center text-lime-950 font-dastnevis"><?php echo e($category->name); ?></h3>
            </a>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/category-list.blade.php ENDPATH**/ ?>