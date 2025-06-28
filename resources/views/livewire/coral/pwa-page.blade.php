<div x-data="menuApp({{ Js::from($categories) }}, {{ Js::from($productsByCategory) }})" x-init="initObserver()" class="max-w-screen-sm mx-auto">
    <!-- هدر ثابت -->
    <header class="fixed top-0 left-0 flex flex-col items-center w-full pt-1 bg-coral-header pb-8 z-40">
        <div class="w-full font-iransans-extrabold relative flex items-center justify-between px-4 h-16">
            <!-- آیکون خانه -->
            <div class="text-coral cursor-pointer" @click="showHomeModal = true">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
            </div>

            <!-- عنوان وسط صفحه -->
            <div class="absolute inset-0 flex justify-center items-center pointer-events-none">
                <div class="text-2xl text-coral">{{ $settings['init_site_name'] }}</div>
            </div>

            <button class="text-coral" @click="showSearch = !showSearch">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M15.75 10.5a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
                </svg>
            </button>
        </div>

        <!-- نوار دسته‌بندی -->
        <div class="w-full overflow-x-auto no-scrollbar">
            <div class="flex w-max items-center space-x-4 px-4 py-2">
                <template x-for="cat in categories" :key="cat.id">
                    <span
                        :data-nav-cat="cat.id"
                        @click="scrollToCategory(cat.id)"
                        :class="activeCategory == cat.id ? 'text-coral font-iransans-bold scale-110' : 'text-black font-iransans-thin scale-100'"
                        class="cursor-pointer px-4 py-2 whitespace-nowrap transition-all duration-300 ease-in-out"
                        x-text="cat.name"
                    ></span>
                </template>
            </div>
        </div>

        <!-- جستجو و دسته بندی -->
        <div class="flex items-center gap-2">
            <button class="bg-coral font-iransans-thin text-white text-sm shadow px-4 py-1 rounded" @click="showModal = true">
                همه دسته‌بندی‌ها
            </button>
        </div>

        <!-- ورودی جستجو -->
        <div x-show="showSearch" class="w-full px-4 pt-2" dir="rtl">
            <div class="flex flex-row-reverse items-center border border-coral rounded overflow-hidden">
                <!-- اینپوت در سمت راست -->
                <input
                    type="text"
                    class="w-full px-4 py-2 text-right text-sm font-iransans-thin placeholder-coral outline-none bg-lime-100"
                    placeholder="جستجوی محصول یا دسته‌بندی..."
                    x-model="searchQuery">

                <!-- دکمه پاک کردن در سمت چپ (در rtl میاد راست) -->
                <button
                    x-show="searchQuery"
                    @click="searchQuery = ''"
                    class="px-3 text-gray-500 hover:text-red-500 transition text-xl"
                    aria-label="پاک کردن جستجو"
                >
                    &times;
                </button>
            </div>
        </div>
        @guest()
            <div dir="rtl" class="absolute bottom-0 right-0 w-full bg-coral-body p-1 mt-2 font-iransans text-[10px] color-coral text-right">جهت ثبت سفارش لطفا بارکد  روی میز را اسکن کنید</div>
        @endguest
    </header>


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

    <!-- لیست محصولات -->
    <div class="pt-40 px-4 mb-4" dir="rtl">
    <template x-for="group in filteredProducts" :key="group.category.id">
        <div :id="`category-${group.category.id}`"
             :data-cat="group.category.id"
             class="py-4 category-section">
            <h2 class="text-lg font-iransans-bold text-coral py-2" x-text="group.category.name"></h2>

            <template x-for="product in group.products" :key="product.id">
                <div class="relative border-b border-black flex py-4 cursor-pointer" @click="openModal(product)">
                    <img :src="product.image_url || '/images/category.jpg'" :alt="product.name" class="h-36 w-36 rounded-2xl shadow" loading="lazy">
                    <div class="p-4 flex flex-col items-start">
                        <h3 class="pb-2 text-lg font-iransans-thin" x-text="product.name"></h3>
                        <span class="font-iransans-regular farsi-number"
                              :class="{'text-[9px]': product.price == 0, 'text-base': product.price != 0}"
                              x-text="product.price == 0 ? 'ناموجود' : (formatPrice(product.price) + ' تومان')">
                        </span>
                        @auth
                        <div class="flex justify-center items-center pt-6">
                            <button
                                x-show="!isInCart(product.id) && product.price != 0"
                                class="font-iransans-thin text-sm mt-2 bg-coral text-white px-3 py-1 rounded hover:bg-orange-500 transition"
                                @click.stop="addToCart(product)">
                                ثبت سفارش
                            </button>
                            <div class="flex justify-center items-center" x-show="isInCart(product.id) && product.price != 0">
                                <button
                                    @click.stop="increaseQuantity(product)"
                                    class="flex justify-center items-center font-iransans-thin text-xl bg-coral text-white px-3 pt-1 rounded hover:bg-orange-500 transition">
                                    +
                                </button>
                                <span class="mx-2 font-iransans-extrabold farsi-number" x-text="productQuantity(product.id)"></span>
                                <button
                                    @click.stop="decreaseQuantity(product)"
                                    class="flex justify-center items-center font-iransans-thin text-xl bg-coral text-white px-3 pt-1 rounded hover:bg-orange-500 transition">
                                    -
                                </button>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </template>
        </div>
    </template>

</div>


    <!-- مودال محصول -->
    <div x-show="showProductModal" x-cloak x-transition
        class="fixed inset-0 z-50 flex items-center justify-center pt-16 pb-16 overflow-auto bg-coral-body"
        @click.away="closeModal"
         dir="rtl"
         @close-modal.window="(event.detail.includes('productModal')) ? showProductModal = false : null"
    >
        <livewire:back modal="productModal" />
        <div class="relative bg-coral-body rounded-lg w-full max-w-3xl mx-auto mt-16 px-6 py-12 overflow-y-auto max-h-screen"
            @click.stop>

            <!-- دکمه بستن خارج از تصویر و با فاصله مناسب از بالا -->
            <button @click="closeModal"
                    class="absolute top-4 right-4 text-coral hover:text-red-500 text-3xl font-bold z-10">
                &times;
            </button>

            <!-- ظرف تصویر با نسبت 16:9 -->
            <div class="aspect-video w-full mb-4 rounded-lg overflow-hidden">
                <img :src="selectedProduct.image_url || '/images/category.jpg'"
                     :alt="selectedProduct.name"
                     class="w-full h-full object-cover shadow" />
            </div>


            <!-- عنوان، قیمت و توضیح -->
            <h2 class="text-xl font-iransans-thin mb-2 text-center" x-text="selectedProduct.name"></h2>
            <p class="text-center font-iransans-regular farsi-number mb-4"
               x-text="selectedProduct.price == 0 ? 'ناموجود' : (formatPrice(selectedProduct.price) + ' تومان')">
            </p>
            <p class="text-justify text-gray-700 font-iransans-thin text-sm"
            x-html="selectedProduct.description || 'توضیحی برای این محصول موجود نیست.'"></p>

            <!-- دکمه بازگشت -->
            <button @click="closeModal"
                    class="text-white w-full bg-coral py-2 mb-16 px-5 rounded mt-10 font-iransans-thin transition">
                بازگشت
            </button>
        </div>
    </div>


    <!--  خانه مودال تمام صفحه -->
        <div
            x-show="showHomeModal"
            x-cloak
            x-transition
            class="fixed inset-0 z-50 flex flex-col items-center justify-between p-8 bg-coral-body"
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
                    @close-modal.window="(event.detail.includes('workHours')) ? showWorkHours = false : null"
                    class="fixed inset-0 bg-coral-body z-50 flex flex-col max-h-screen overflow-y-auto px-6 py-10"
                    style="display: none;"
                    dir="rtl"
                >
                    <livewire:back modal="workHours"/>
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
                    @close-modal.window="(event.detail.includes('about')) ? showAbout = false : null"


                    class="fixed inset-0 bg-coral-body z-50 flex flex-col max-h-screen overflow-y-auto px-6 py-10"
                    style="display: none;"
                    dir="rtl"
                >
                    <livewire:back modal="about"/>
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
                    @close-modal.window="(event.detail.includes('contact')) ? showContact = false : null"
                    class="fixed inset-0 bg-coral-body z-50 flex flex-col max-h-screen overflow-y-auto px-6 py-10"
                    style="display: none;"
                    dir="rtl"
                >
                    <livewire:back modal="contact"/>
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

    @auth
        <livewire:coral.user-area/>
        <livewire:coral.cart-area/>
        <livewire:call-waiter/>
    @endauth
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('productList', () => ({
            categories: [],           // لیست دسته‌بندی‌ها
            products: [],             // لیست محصولات
            searchQuery: '',          // متن جستجو
            activeCategoryId: null,   // دسته‌بندی فعال
            showProductModal: false,  // نمایش مودال محصول
            showCategoryModal: false, // نمایش مودال دسته‌بندی
            showHomeModal: false,     // نمایش مودال صفحه اصلی
            showCartModal: false,     // سبد خرید
            selectedProduct: null,    // محصول انتخاب شده
            selectedCategory: null,   // دسته‌بندی انتخاب شده
            cart: [],
            init() {
                this.setupIntersectionObserver();
            },

            filteredProducts() {
                if (!this.searchQuery.trim()) return this.products;

                const q = this.searchQuery.toLowerCase();
                return this.products.filter(product =>
                    product.name.toLowerCase().includes(q) ||
                    (product.description && product.description.toLowerCase().includes(q))
                );
            },

            selectCategory(id) {
                this.activeCategoryId = id;
                this.scrollToCategory(id);
            },

            scrollToCategory(id) {
                const el = document.getElementById(`category-${id}`);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            },

            openProductModal(product) {
                this.selectedProduct = product;
                this.showProductModal = true;
            },

            closeProductModal() {
                this.showProductModal = false;
                this.selectedProduct = null;
            },

            openCategoryModal(category) {
                this.selectedCategory = category;
                this.showCategoryModal = true;
            },

            closeCategoryModal() {
                this.showCategoryModal = false;
                this.selectedCategory = null;
            },

            openHomeModal() {
                this.showHomeModal = true;
            },

            closeHomeModal() {
                this.showHomeModal = false;
            },

            openCartModal() {
                this.showCartModal = true;
            },

            closeCartModal() {
                this.showCartModal = false;
            },

            setupIntersectionObserver() {
                const options = {
                    root: document.querySelector('#products-container'),
                    rootMargin: '0px',
                    threshold: 0.5,
                };

                const callback = (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const categoryId = entry.target.getAttribute('data-category-id');
                            if (categoryId) {
                                this.activeCategoryId = categoryId;
                                // برای به‌روزرسانی UI یا نوار دسته‌بندی بالایی
                            }
                        }
                    });
                };

                const observer = new IntersectionObserver(callback, options);

                // صبر کن تا DOM بارگذاری بشه و دسته‌بندی‌ها را انتخاب کن
                this.$nextTick(() => {
                    const categoryElements = document.querySelectorAll('.category-section');
                    categoryElements.forEach(el => observer.observe(el));
                });
            }
        }));
    });

function menuApp(categories, productsByCategory) {
    return {
        categories,
        productsByCategory,
        searchQuery: '',
        showSearch: false,
        showModal: false,
        showHomeModal: true,
        showProductModal: false,
        selectedProduct: {},
        showWorkHours: false,
        showAbout: false,
        showContact: false,
        activeCategory: categories[0]?.id || null,
        cart: [],

        init() {
            const savedCart = localStorage.getItem('cart');
            if (savedCart) {
                this.cart = JSON.parse(savedCart);
            }

            // بررسی URL
            if (window.location.search.includes('page=menu')) {
                this.showHomeModal = false;
            }
            this.initObserver(); // حتما اینجا صدا زده شود
        },

        get filteredProducts() {
            if (!this.searchQuery) return this.productsByCategory;
            const query = this.searchQuery.toLowerCase();
            return this.productsByCategory
                .map(group => {
                    const filtered = group.products.filter(p =>
                        p.name.toLowerCase().includes(query)
                    );
                    return filtered.length ? { ...group, products: filtered } : null;
                })
                .filter(Boolean);
        },

        initObserver() {
            setTimeout(() => {
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const categoryId = entry.target.getAttribute('data-cat');
                            if (categoryId) {
                                this.activeCategory = Number(categoryId);
                                const nav = document.querySelector(`[data-nav-cat='${categoryId}']`);
                                nav?.scrollIntoView({ behavior: 'smooth', inline: 'center' });
                            }
                        }
                    });
                }, { threshold: 0.5 });

                document.querySelectorAll('.category-section').forEach(el => observer.observe(el));
            }, 300); // تاخیر کوتاه برای اطمینان از کامل بودن DOM
        },

        addToCart(product) {
            let existing = this.cart.find(item => item.id === product.id);
            if (existing) {
                existing.quantity++;
            } else {
                this.cart.push({ ...product, quantity: 1 });
            }
            localStorage.setItem('cart', JSON.stringify(this.cart));
        },

        increaseQuantity(product) {
            let existing = this.cart.find(item => item.id === product.id);
            if (existing) {
                existing.quantity++;
            } else {
                this.cart.push({ ...product, quantity: 1 });
            }
            localStorage.setItem('cart', JSON.stringify(this.cart));
        },

        decreaseQuantity(product) {
            const existingIndex = this.cart.findIndex(item => item.id === product.id);

            if (existingIndex !== -1) {
                this.cart[existingIndex].quantity--;

                if (this.cart[existingIndex].quantity === 0) {
                this.cart.splice(existingIndex, 1);
                }
            }
            localStorage.setItem('cart', JSON.stringify(this.cart));
        },

        isInCart(productId) {
            return this.cart.some(item => item.id === productId);
        },

        productQuantity(productId) {
            if(this.isInCart(productId)) {
                let cart = this.cart.find(item => item.id === productId);
                return cart.quantity
            }
            return null
        },

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

        openModal(product) {
            this.selectedProduct = product;
            this.showProductModal = true;
        },

        closeModal() {
            this.showProductModal = false;
            this.selectedProduct = {};
        },

        formatPrice(price) {
            if (typeof price !== 'number' || isNaN(price)) {
                return '۰';
            }
            return price.toLocaleString('fa-IR');
        },
    };
}
</script>
@endpush
