<!-- Header -->
<header class="bg-[#cce0a1] h-16 w-full shadow-md flex items-center justify-between px-4">
    <img src="{{ asset('images/logo.png')}}" alt="Logo" class="h-10 w-auto rounded-md" />
    <nav dir="rtl" class="hidden sm:block">
        <ul class="flex justify-center space-x-6 rtl:space-x-reverse py-4 text-gray-700 font-medium font-dastnevis">
            <li><a href="/" class="hover:text-lime-700">خانه</a></li>
            <li><a href="/orders" class="hover:text-lime-700">سفارشات</a></li>
            <li><a href="/cart" class="hover:text-lime-700">سبد خرید</a></li>
            <li><a href="/search" class="hover:text-lime-700">جستجو</a></li>
            <li><a href="/profile" class="hover:text-lime-700">پروفایل</a></li>
        </ul>
    </nav>
    <span class="text-footer text-xl font-iransans-thin">{{ $title }}</span>
</header>