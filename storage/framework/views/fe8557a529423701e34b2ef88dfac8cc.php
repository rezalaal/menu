<div class="px-4 mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="/products/<?php echo e($category->id); ?>" wire:navigate
           class="group relative rounded-xl overflow-hidden shadow-xl transform hover:scale-105 transition duration-300 bg-white">
            <img src="<?php echo e($category->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg'); ?>"
                 alt="<?php echo e($category->name); ?>"
                 class="w-full h-36 object-cover object-center">

            
            <div class="absolute bottom-0 w-full bg-lime-800/40 backdrop-blur-sm text-white text-center py-2">
                <h3 class="font-dastnevis text-md truncate px-2" title="<?php echo e($category->name); ?>"><?php echo e($category->name); ?></h3>
            </div>



            
            <div class="absolute top-2 left-2 bg-white text-lime-800 text-xs px-2 py-0.5 rounded-full shadow font-dastnevis farsi-number">
                <?php echo e($category->products_count ?? 0); ?>

            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/category-list.blade.php ENDPATH**/ ?>