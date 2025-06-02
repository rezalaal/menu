<div class="px-4 mt-4 grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-5">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="/products/<?php echo e($category->id); ?>" wire:navigate class="flex flex-col items-center space-y-2">
            <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-lime-600 shadow-md">
                <img src="<?php echo e($category->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg'); ?>" alt="<?php echo e($category->name); ?>"
                     class="w-full h-full object-cover object-center">
            </div>
            <h3 class="text-center text-lime-950 font-dastnevis text-sm"><?php echo e($category->name); ?></h3>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/category-list.blade.php ENDPATH**/ ?>