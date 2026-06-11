<header class="bg-gradient-header h-16 w-full shadow-soft flex items-center justify-between px-4 sticky top-0 z-50 backdrop-blur-sm">
    <img src="{{ asset('images/logo.png')}}" alt="Logo" class="h-10 w-auto rounded-xl shadow-soft" />
    <nav dir="rtl" class="hidden sm:block">
        <ul class="flex justify-center space-x-6 rtl:space-x-reverse py-4">
            <li>
                <a href="/" wire:navigate class="text-coral-from/80 hover:text-coral-from font-iransans-thin text-sm relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-coral-from after:transition-all after:duration-300 hover:after:w-full">خانه</a>
            </li>
            <li>
                <a href="/orders" wire:navigate class="text-coral-from/80 hover:text-coral-from font-iransans-thin text-sm relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-coral-from after:transition-all after:duration-300 hover:after:w-full">سفارشات</a>
            </li>
            <li>
                <a href="/cart" wire:navigate class="text-coral-from/80 hover:text-coral-from font-iransans-thin text-sm relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-coral-from after:transition-all after:duration-300 hover:after:w-full">سبد خرید</a>
            </li>
            <li>
                <a href="/search" wire:navigate class="text-coral-from/80 hover:text-coral-from font-iransans-thin text-sm relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-coral-from after:transition-all after:duration-300 hover:after:w-full">جستجو</a>
            </li>
            <li>
                <a href="/profile" wire:navigate class="text-coral-from/80 hover:text-coral-from font-iransans-thin text-sm relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-coral-from after:transition-all after:duration-300 hover:after:w-full">پروفایل</a>
            </li>
        </ul>
    </nav>
    <span class="text-coral-from/60 text-sm font-iransans-thin">{{ $title }}</span>
</header>
