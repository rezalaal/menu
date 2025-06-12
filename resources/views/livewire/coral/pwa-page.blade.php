<div x-data="categoryScroll({{ Js::from($categories) }})"
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
     "
     class="max-w-screen-sm mx-auto"
>


<!-- هدر ثابت -->
    <header class="fixed top-0 left-0 flex flex-col items-center w-full pt-1 bg-white pb-2 z-40">
        <!-- نوار بالا با آیکون و عنوان -->
        <div class="w-full font-iransans-extrabold relative flex items-center justify-start px-4 h-16">
            <!-- آیکون سمت راست -->
            <div class="text-coral cursor-pointer" @click="showHomeModal = true">
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
        <div class="w-full overflow-x-auto no-scrollbar">
            <div class="flex w-max items-center space-x-4 px-4 py-2">
                @foreach($categories as $index => $cat)
                    <span
                        data-nav-cat="{{ $cat['id'] }}"
                        @click="scrollToCategory({{ $cat['id'] }})"
                        :class="activeCategory == '{{ $cat['id'] }}' ? 'text-coral font-iransans-bold scale-110' : 'text-black font-iransans-thin scale-100'"
                        class="cursor-pointer px-4 py-2 whitespace-nowrap transition-all duration-300 ease-in-out"
                    >
                    {{ $cat['name'] }}
                </span>


                @if ($index !== count($categories) - 1)
                        <!-- خط تیره بزرگتر -->
                        <span class="text-coral text-2xl select-none">—</span>
                    @endif
                @endforeach
            </div>
        </div>

        <!--  خانه مودال تمام صفحه -->
        <div
            x-show="showHomeModal"
            x-cloak
            x-transition
            class="fixed inset-0 bg-white bg-opacity-95 z-50 flex flex-col items-center justify-between p-8"
            @click.away="showHomeModal = false"
        >
            <!-- عنوان وسط صفحه -->
            <div class="flex-grow flex items-center justify-center">
                <h1 class="text-4xl text-coral font-iransans-bold text-center">
                    {{ $settings['init_site_name'] }}
                </h1>
            </div>

            <!-- دکمه‌ها پایین صفحه -->
            <div class="w-full">
                <!-- دکمه‌ها پایین صفحه -->
                <div class="w-full max-w-md grid grid-cols-1 gap-4 pb-8 px-16">
                    <button
                        class="bg-coral text-white py-3 rounded font-iransans-thin"
                        @click="showHomeModal = false"
                    >
                        مشاهده منوی دیجیتال
                    </button>
                    <button
                        class="text-coral border border-coral py-3 rounded font-iransans-thin"
                        @click="showWorkHours = true"
                    >
                        ساعت کار
                    </button>
                    <button
                        class="text-coral border border-coral py-3 rounded font-iransans-thin"
                        @click="showAbout = true"
                    >
                        درباره ما
                    </button>
                    <button
                        class="text-coral border border-coral py-3 rounded font-iransans-thin"
                        @click="showContact = true"
                    >
                        اطلاعات تماس
                    </button>
                </div>

                <!-- مودال ساعت کاری -->
                <div
                    x-show="showWorkHours"
                    class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-center px-8 text-center"
                    style="display: none;"
                >
                    <div class="text-xl mb-8 font-iransans-thin">ساعات کاری رستوران: هر روز از ۱۲ تا ۲۳</div>
                    <button
                        class="text-coral border border-coral py-3 px-6 rounded font-iransans-thin mt-auto mb-8"
                        @click="showWorkHours = false"
                    >
                        بازگشت به خانه
                    </button>
                </div>

                <!-- مودال درباره ما -->
                <div
                    x-show="showAbout"
                    class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-center px-8 text-center"
                    style="display: none;"
                >
                    <div class="text-xl mb-8 font-iransans-thin">رستوران ما با ۲۰ سال تجربه، بهترین غذاهای سنتی را ارائه می‌دهد.</div>
                    <button
                        class="text-coral border border-coral py-3 px-6 rounded font-iransans-thin mt-auto mb-8"
                        @click="showAbout = false"
                    >
                        بازگشت به خانه
                    </button>
                </div>

                <!-- مودال اطلاعات تماس -->
                <div
                    x-show="showContact"
                    class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-center px-8 text-center"
                    style="display: none;"
                >
                    <div class="text-xl mb-8 font-iransans-thin">
                        شماره تماس: ۰۲۱-۱۲۳۴۵۶۷۸<br>
                        آدرس: تهران، خیابان نمونه، پلاک ۱۰
                    </div>
                    <button
                        class="text-coral border border-coral py-3 px-6 rounded font-iransans-thin mt-auto mb-8"
                        @click="showContact = false"
                    >
                        بازگشت به خانه
                    </button>
                </div>
            </div>

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
                    class="w-52 mx-auto text-lg text-black py-2 px-4 border-b border-black cursor-pointer hover:bg-gray-200 transition"
                    @click="scrollToCategory({{ $category['id'] }})"
                >
                    {{ $category['name'] }}
                </div>
            @endforeach

        </div>

    </div>

    <!-- لیست محصولات گروه‌بندی‌شده -->
    <div x-data="productModal()" class="relative">

        <div id="prod-list" class="pt-40 w-full px-4 mb-4" dir="rtl">
            @foreach($productsByCategory as $group)
                <div data-cat="{{ $group['category']['id'] }}" class="py-4">
                    <h2 class="text-xl font-iransans-bold text-coral py-2">{{ $group['category']['name'] }}</h2>

                    @foreach($group['products'] as $product)
                        <div
                            class="border-b border-black flex py-4 cursor-pointer"
                            @click="openModal({{ Js::from($product) }})"
                        >
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

        <!-- مودال محصول -->
        <div
            x-show="showModal"
            x-cloak
            x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
            @click.away="closeModal()"
            dir="rtl"
        >
            <div class="bg-white rounded-lg max-w-lg w-full p-6 relative" @click.stop>
                <button
                    @click="closeModal()"
                    class="absolute top-2 right-2 text-coral hover:text-red-500 text-2xl font-bold"
                    aria-label="بستن مودال"
                >&times;</button>

                <img :src="selectedProduct.image_url" :alt="selectedProduct.name" class="mx-auto rounded-lg mb-4 max-h-64 object-contain" />

                <h2 class="text-2xl font-iransans-bold mb-2 text-center" x-text="selectedProduct.name"></h2>

                <p class="text-center font-iransans-regular farsi-number mb-4" x-text="selectedProduct.price + ' تومان'"></p>

                <p class="text-justify text-gray-700" x-text="selectedProduct.description || 'توضیحی برای این محصول موجود نیست.'"></p>
            </div>
        </div>

    </div>
</div>
@push('scripts')
    <script>
        function categoryScroll(categories) {
            return {
                showModal: false,
                showHomeModal: true,
                showAbout: false,
                showContact: false,
                showWorkHours: false,
                activeCategory: categories[0].id,
                scrollToCategory(catId) {
                    this.showModal = false;
                    setTimeout(() => {
                        const target = document.querySelector(`[data-cat='${catId}']`);

                        if (target) {
                            const offset = target.getBoundingClientRect().top + window.scrollY - 180;
                            window.scrollTo({ top: offset, behavior: 'smooth' });
                        } else {
                            console.warn('Target not found:', catId);
                        }
                    }, 300);
                }

            }
        }
        function productModal() {
            return {
                showModal: false,
                selectedProduct: {},
                openModal(product) {
                    this.selectedProduct = product;
                    this.showModal = true;
                },
                closeModal() {
                    this.showModal = false;
                    this.selectedProduct = {};
                }
            }
        }
    </script>
@endpush
