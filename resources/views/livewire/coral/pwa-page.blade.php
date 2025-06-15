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
            class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-between p-8"
            @click.away="showHomeModal = false"
        >
            <!-- عنوان وسط صفحه -->
            <div class="flex-grow flex items-center justify-center">
                <h1 class="text-4xl text-coral font-iransans-bold text-center">
                    {{ $settings['init_site_name'] }}
                </h1>
            </div>

            <!-- دکمه‌ها پایین صفحه -->
            <div class="w-full flex flex-col items-center">
            <!-- دکمه‌ها پایین صفحه -->
                <div class="w-full max-w-md grid grid-cols-1 gap-2 pb-8 px-4">
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
                    x-transition
                    x-cloak
                    class="fixed inset-0 bg-white z-50 flex flex-col max-h-screen overflow-y-auto px-6 py-10"
                    style="display: none;"
                    dir="rtl"
                >
                    <div class="text-sm font-iransans-thin text-black leading-relaxed space-y-2 max-w-xl mx-auto">
                        {!! Str::markdown(strip_tags($settings['work_hours'] ?? 'ساعات کاری ثبت نشده است.')) !!}
                    </div>

                    <button
                        class="text-coral border border-coral py-2 px-5 rounded mt-10 font-iransans-thin hover:bg-coral hover:text-white transition"
                        @click="showWorkHours = false"
                    >
                        بازگشت به خانه
                    </button>
                </div>


                <!-- مودال درباره ما -->
                <div
                    x-show="showAbout"
                    x-transition
                    x-cloak
                    class="fixed inset-0 bg-white z-50 flex flex-col max-h-screen overflow-y-auto px-6 py-10"
                    style="display: none;"
                    dir="rtl"
                >
                    <div class="text-sm font-iransans-thin text-black leading-relaxed max-w-xl mx-auto space-y-4">
                        {!! Str::markdown(strip_tags($settings['about'] ?? 'توضیحاتی برای این بخش موجود نیست.')) !!}
                    </div>

                    <button
                        class="text-coral border border-coral py-2 px-5 rounded mt-10 font-iransans-thin hover:bg-coral hover:text-white transition"
                        @click="showAbout = false"
                    >
                        بازگشت به خانه
                    </button>
                </div>


                <!-- مودال اطلاعات تماس -->
                <div
                    x-show="showContact"
                    x-transition
                    x-cloak
                    class="fixed inset-0 bg-white z-50 flex flex-col max-h-screen overflow-y-auto px-6 py-10"
                    style="display: none;"
                    dir="rtl"
                >
                    <div class="text-sm font-iransans-thin text-black leading-relaxed max-w-xl mx-auto space-y-4">
                        {!! Str::markdown(strip_tags($settings['contact'] ?? 'اطلاعات تماس موجود نیست.')) !!}
                    </div>

                    <button
                        class="text-coral border border-coral py-2 px-5 rounded mt-10 font-iransans-thin hover:bg-coral hover:text-white transition"
                        @click="showContact = false"
                    >
                        بازگشت به خانه
                    </button>
                </div>

            </div>

        </div>

        <div class="flex gap-4">
            <!-- دکمه باز کردن مودال -->
            <button
                class="bg-coral font-iransans-thin text-white text-sm shadow px-8 py-2 mt-1"
                @click="showModal = true"
            >
                همه دسته بندی ها
            </button>
            <!-- دکمه جستجو -->
            <button
                class="ml-2 text-coral"
                @click="showSearch = true"
                aria-label="جستجو"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                </svg>
            </button>
        </div>

    </header>

    <!-- مودال جستجو -->
    <div
        x-show="showSearch"
        x-cloak
        x-transition
        class="fixed inset-0 bg-white z-50 flex flex-col p-6 overflow-auto"
        @click.away="showSearch = false"
        dir="rtl"
    >
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-iransans-bold text-coral">جستجو</h2>
            <button @click="showSearch = false" aria-label="بستن" class="text-coral hover:text-red-500 text-3xl">&times;</button>
        </div>

        <input
            type="text"
            x-model="searchQuery"
            placeholder="نام محصول یا دسته‌بندی..."
            class="border border-coral rounded p-2 mb-4 font-iransans-thin"
        >

        <div class="space-y-2">
            <!-- نتایج محصولات -->
            <template x-for="group in filteredProducts" :key="group.category.id">
                <div>
                    <h3 class="text-coral font-iransans-bold" x-text="group.category.name"></h3>
                    <ul class="pl-4 list-disc">
                        <template x-for="product in group.products" :key="product.id">
                            <li>
                                <span class="cursor-pointer hover:underline"
                                    @click="openModal(product); showSearch = false"
                                    x-text="product.name"
                                ></span>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>

            <!-- نتایج دسته‌بندی -->
            <template x-for="cat in filteredCategories" :key="cat.id">
                <div>
                    <span
                        class="cursor-pointer text-coral hover:underline"
                        @click="scrollToCategory(cat.id); showSearch = false"
                        x-text="'دسته‌بندی: ' + cat.name"
                    ></span>
                </div>
            </template>
        </div>
    </div>

    <!-- مودال تمام‌صفحه -->
    <div
        x-show="showModal"
        x-cloak
        x-transition
        class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-center p-8"
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
                    class="w-52 mx-auto font-iransans-thin text-lg text-black py-2 px-4 border-b border-black cursor-pointer hover:bg-gray-200 transition"
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
                            <img 
                                src="{{ $product['image_url'] ?: asset('images/category.jpg') }}" 
                                alt="{{ $product['name'] }}" 
                                class="h-36 w-36 rounded-2xl shadow"
                            >

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
            class="fixed inset-0 bg-white z-50 flex items-center justify-center py-8 mt-2 overflow-auto"
            @click.away="closeModal()"
            dir="rtl"
        >
            <div
                class="bg-white rounded-lg w-full max-w-3xl mx-auto my-8 p-6 relative overflow-y-auto max-h-screen"
                @click.stop
            >
                <!-- دکمه بستن -->
                <button
                    @click="closeModal()"
                    class="absolute top-4 right-4 text-coral hover:text-red-500 text-5xl font-bold z-10"
                    aria-label="بستن مودال"
                >&times;</button>

                <!-- تصویر محصول -->
                <img
                    :src="selectedProduct.image_url ? selectedProduct.image_url : '/images/category.jpg'"
                    :alt="selectedProduct.name"
                    class="mx-auto rounded-lg mb-4 max-h-64 object-contain"
                >


                <!-- نام محصول -->
                <h2 class="text-2xl font-iransans-thin mb-2 text-center"
                    x-text="selectedProduct.name"></h2>

                <!-- قیمت -->
                <p class="text-center font-iransans-regular farsi-number mb-4"
                    x-text="selectedProduct.price + ' تومان'"></p>

                <!-- توضیحات -->
                <p class="text-justify text-gray-700 font-iransans-thin text-sm"
                    x-html="selectedProduct.description || 'توضیحی برای این محصول موجود نیست.'"></p>
                <button
                    class="text-white w-full bg-coral py-2 px-5 rounded mt-10 font-iransans-thin transition"
                    @click="closeModal()"
                >
                    بازگشت
                </button>
            </div>
        </div>

    </div>
</div>
@push('scripts')
    <script>
        window.onpopstate = function(event) {
            // این تابع هنگام کلیک روی back اجرا می‌شود
            console.log("کاربر back زد");
            // مثلاً:
            if (!confirm("آیا مطمئنید می‌خواهید برگردید؟")) {
                history.pushState(null, null, location.href); // کاربر را در همین صفحه نگه می‌دارد
            }
        };


        function categoryScroll(categories) {
        return {
            showModal: false,
            showHomeModal: true,
            showAbout: false,
            showContact: false,
            showWorkHours: false,
            showSearch: false,
            searchQuery: '',
            activeCategory: categories[0].id,
            scrollToCategory(catId) {
                this.showModal = false;
                setTimeout(() => {
                    const target = document.querySelector(`[data-cat='${catId}']`);
                    if (target) {
                        const offset = target.getBoundingClientRect().top + window.scrollY - 180;
                        window.scrollTo({ top: offset, behavior: 'smooth' });
                    }
                }, 300);
            },
            get filteredProducts() {
                if (!this.searchQuery.trim()) return [];
                const query = this.searchQuery.toLowerCase();
                return @js($productsByCategory).map(group => {
                    const matched = group.products.filter(p =>
                        p.name.toLowerCase().includes(query)
                    );
                    return matched.length ? { ...group, products: matched } : null;
                }).filter(Boolean);
            },
            get filteredCategories() {
                if (!this.searchQuery.trim()) return [];
                const query = this.searchQuery.toLowerCase();
                return categories.filter(cat => cat.name.toLowerCase().includes(query));
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
