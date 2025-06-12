<div x-data="{ showModal: false, activeCategory: @js($categories[0]['id']) }"
     x-init="
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    activeCategory = entry.target.dataset.cat;
                    const nav = document.querySelector(`[data-nav-cat='${activeCategory}']`);
                    nav?.scrollIntoView({ behavior: 'smooth', inline: 'center' });
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('[data-cat]').forEach(el => observer.observe(el));
     ">

    <!-- هدر ثابت -->
    <header class="fixed top-0 left-0 flex flex-col items-center w-full pt-1 bg-white pb-2 z-40">
        <!-- نوار بالا با آیکون و عنوان -->
        <div class="w-full font-iransans-extrabold relative flex items-center justify-start px-4 h-16">
            <!-- آیکون سمت راست -->
            <div class="text-coral">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0
                          .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125
                          1.125-1.125h2.25c.621 0 1.125.504
                          1.125 1.125V21h4.125c.621 0 1.125-.504
                          1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </div>

            <!-- عنوان وسط صفحه -->
            <div class="absolute inset-0 flex justify-center items-center pointer-events-none">
                <div class="text-2xl">{{ $settings['init_site_name'] }}</div>
            </div>
        </div>

        <!-- نوار دسته‌بندی بالا -->
        <div class="flex overflow-x-auto space-x-4 px-4 py-2 no-scrollbar">
            @foreach($categories as $cat)
                <span
                    data-nav-cat="{{ $cat['id'] }}"
                    @click="document.querySelector(`[data-cat='{{ $cat['id'] }}']`).scrollIntoView({ behavior: 'smooth', block: 'start' })"
                    :class="activeCategory == '{{ $cat['id'] }}' ? 'text-coral font-iransans-bold' : 'text-black font-iransans-thin'"
                    class="cursor-pointer px-4 py-2 whitespace-nowrap transition"
                >
                    {{ $cat['name'] }}
                </span>
            @endforeach
        </div>

        <!-- دکمه باز کردن مودال -->
        <button
            class="bg-coral font-iransans-thin text-white text-sm shadow px-8 py-2 mt-1"
            @click="showModal = true"
        >
            همه دسته بندی ها
        </button>
    </header>

    <!-- مودال تمام‌صفحه -->
    <div
        x-show="showModal"
        x-cloak
        x-transition
        class="fixed inset-0 bg-white bg-opacity-95 z-50 flex flex-col items-center justify-center p-8"
        @click.away="showModal = false"
    >
        <!-- دکمه بستن -->
        <button
            @click="showModal = false"
            class="absolute top-4 left-4 text-coral hover:text-red-500 transition"
            aria-label="بستن"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                 stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- عنوان مودال -->
        <h2 class="text-xl font-iransans-bold mb-4 text-coral">لیست دسته‌بندی‌ها</h2>

        <!-- لیست دسته‌بندی‌ها -->
        <div class="flex flex-col space-y-4 w-full max-w-md text-center overflow-y-auto max-h-[70vh]">
            @foreach($categories as $category)
                <div
                    class="w-52 mx-auto text-lg text-black py-2 px-4 border-b border-black cursor-pointer hover:bg-gray-200 transition">
                    {{ $category['name'] }}
                </div>
            @endforeach
        </div>
    </div>

    <!-- لیست محصولات گروه‌بندی‌شده -->
    <div id="prod-list" class="pt-48 w-full px-4 mb-4 h-[calc(100vh-10rem)] overflow-y-auto" dir="rtl">
        @foreach($productsByCategory as $group)
            <div data-cat="{{ $group['category']['id'] }}" class="py-4">
                <!-- عنوان دسته‌بندی -->
                <h2 class="text-xl font-iransans-bold text-coral py-2">{{ $group['category']['name'] }}</h2>

                <!-- محصولات -->
                @foreach($group['products'] as $product)
                    <div class="border-b border-black flex py-4">
                        <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="h-36 w-36 rounded-2xl shadow">
                        <div class="p-4">
                            <h3 class="pb-2 text-xl font-iransans-ultralight">{{ $product['name'] }}</h3>
                            <span class="font-iransans-regular farsi-number">{{ $product['price'] }} تومان</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
