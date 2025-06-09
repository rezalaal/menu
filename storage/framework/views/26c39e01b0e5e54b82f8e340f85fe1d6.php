<div class="relative min-h-screen">
    <!-- ویدیو پس‌زمینه -->
    <video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover z-[-2]">
        <source src="<?php echo e($tableVideoUrl ?? asset('videos/coral.mp4')); ?>" type="video/mp4">
    </video>

    <!-- لایه تار برای خوانایی بهتر محتوا -->
    <div class="fixed top-0 left-0 w-full h-full bg-black/40 z-[-1]"></div>

    <!-- محتوای صفحه -->
    <div class="relative pb-16 font-iransans-regular min-h-screen flex flex-col justify-between items-center p-6">
        <!-- تصویر و عنوان -->
        <div x-data="{ visible: false }" @click.away="visible = false" class="flex flex-col items-center mt-6 group">
            <!-- تصویر -->
            <img
                @mouseenter="visible = true"
                @mouseleave="visible = false"
                @click="visible = !visible"
                :class="{ 'opacity-100': visible, 'opacity-10': !visible }"
                class="rounded-full w-44 h-44 shadow-2xl mb-4 transition-opacity duration-500"
                src="<?php echo e($tableImageUrl); ?>"
                alt="table image"
            >

            <!-- عنوان -->
            <span class="font-mallanna text-4xl pt-2 text-shadow gradient-text animate-gradient text-center">
        <?php echo e($settings['title']); ?>

    </span>
            <span class="pt-3 text-white font-dastnevis text-xl text-center" dir="rtl">
        <?php echo e($tableName); ?>

    </span>
        </div>


    <!--[if BLOCK]><![endif]--><?php if(auth()->guard()->guest()): ?>
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('login-form', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2123860938-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]--><?php if(auth()->guard()->check()): ?>
            <a wire:navigate href="/" class="font-dastnevis text-center text-lime-800 hover:text-lime-100 bg-[#FF2D20]/10">جهت مشاهده منو کلیک کنید</a>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- اطلاعات تماس -->
        <div class="w-full flex justify-around text-lime-900 text-sm flex-wrap gap-6 mt-4 mb-4">
            <!-- اینستاگرام -->
            <a href="https://instagram.com/<?php echo e($settings['instagram']); ?>" target="_blank" class="flex no-underline hover:underline items-center hover:text-pink-200 transition-all">
                <svg class="w-6 h-6 mx-2 fill-current text-pink-600 hover:text-pink-800 transition-colors duration-200" viewBox="0 0 24 24">
                    <!-- ... -->
                </svg>
                <span class="font-iransans-ultralight underline"><?php echo e('@' . $settings['instagram']); ?></span>
            </a>

            <!-- تلفن -->
            <a href="tel:<?php echo e($settings['mobile']); ?>" class="flex no-underline hover:underline items-center hover:text-green-200 transition-all">
                <svg class="w-6 h-6 mx-2 fill-current text-[#1FC85F]" viewBox="0 0 24 24">
                    <!-- ... -->
                </svg>
                <span class="font-iransans-ultralight underline farsi-number"><?php echo e($settings['mobile']); ?></span>
            </a>
        </div>
    </div>
</div>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/livewire/table.blade.php ENDPATH**/ ?>