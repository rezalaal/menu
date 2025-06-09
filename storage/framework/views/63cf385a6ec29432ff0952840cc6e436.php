<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('images/favicon/apple-touch-icon.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/favicon/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('images/favicon/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('images/favicon/site.webmanifest')); ?>">
    <link rel="mask-icon" href="<?php echo e(asset('images/favicon/safari-pinned-tab.svg')); ?>" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Mallanna&family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Sacramento&display=swap" rel="stylesheet">

    <link rel="manifest" href="<?php echo e(asset('/manifest.json')); ?>">
    <title><?php echo e($title ?? 'Coral Food کورال فود'); ?></title>
</head>
<body class="bg-coral-to"
      x-data="{ navigating: false, showLoader: false }"
      x-init="
        window.addEventListener('livewire:navigating', () => {
            navigating = true;
            showLoader = true;
        });
        window.addEventListener('livewire:navigated', () => {
            navigating = false;
            setTimeout(() => {
                if (!navigating) showLoader = false;
            }, 300);
        });
      ">

    <!-- Header -->
    <header class="bg-[#cce0a1] h-16 w-full shadow-md flex items-center justify-between px-4">
        <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Logo" class="h-10 w-auto rounded-md" />
        <nav dir="rtl" class="hidden sm:block">
            <ul class="flex justify-center space-x-6 rtl:space-x-reverse py-4 text-gray-700 font-medium">
                <li><a href="/" class="hover:text-lime-700">خانه</a></li>
                <li><a href="/orders" class="hover:text-lime-700">سفارشات</a></li>
                <li><a href="/cart" class="hover:text-lime-700">سبد خرید</a></li>
                <li><a href="/search" class="hover:text-lime-700">جستجو</a></li>
                <li><a href="/profile" class="hover:text-lime-700">پروفایل</a></li>
            </ul>
        </nav>
        <span class="text-footer text-xl font-iransans-thin">Coral Food Online Menu</span>
    </header>

    <!-- Main Slot -->
    <div class="max-w-screen-sm mx-auto">
        <?php echo e($slot); ?>

    </div>

    <!-- Loading Overlay -->
    <div x-show="showLoader"
         x-transition.opacity
         class="fixed inset-0 z-50 bg-black bg-opacity-40 flex flex-col justify-center items-center">
        <svg class="animate-spin h-10 w-10 text-lime-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <p class="text-lime-100 mt-4 text-xl font-dastnevis">در حال بارگذاری...</p>
    </div>

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH /home/Happy/Projects/Laravel/coral/coral/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>