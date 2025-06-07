<div wire:poll.5s class="p-6 bg-white rounded shadow max-w-xl mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4 text-gray-700">📋 وضعیت میزها</h2>

    <!--[if BLOCK]><![endif]--><?php if($calledTables->isEmpty()): ?>
        <p class="text-gray-500">هیچ میزی در حال حاضر درخواست گارسون ندارد.</p>
    <?php else: ?>
        <ul class="space-y-3">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $calledTables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded flex justify-between items-center">
                    <span>🛎️ میز <strong><?php echo e($table->name); ?></strong> نیاز به گارسون دارد!</span>
                    <button wire:click="markAsHandled(<?php echo e($table->id); ?>)"
                            class="bg-lime-600 hover:bg-lime-700 text-white px-3 py-1 rounded">
                        رسیدگی شد ✅
                    </button>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </ul>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    

</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/waiter-page.blade.php ENDPATH**/ ?>