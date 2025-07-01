<div
    x-data="menuApp({{ Js::from($categories) }}, {{ Js::from($productsByCategory) }})"
    x-init="init()"
    @show-favorites.window="showFavoritesOnly = !showFavoritesOnly"
    class="max-w-screen-sm mx-auto"
>
    <!-- هدر ثابت -->
    <header class="fixed top-0 left-0 flex flex-col items-center w-full pt-1 bg-coral-header pb-8 z-40">
        
        <div class="w-full font-iransans-extrabold relative flex items-center justify-between px-4 h-16">
            <!-- آیکون خانه -->
            <div class="text-coral cursor-pointer" @click="openModal('Home')">
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
            <button class="bg-coral font-iransans-thin text-white text-sm shadow px-4 py-1 rounded" @click="showCategories = true">
                همه دسته‌بندی‌ها
            </button>
        </div>

        <!-- ورودی جستجو -->
        <div x-show="showSearch" class="w-full px-4 pt-2" dir="rtl">
            <div class="relative flex flex-row-reverse items-center border border-coral rounded overflow-hidden">
                <!-- اینپوت -->
                <input
                    type="text"
                    class="w-full pr-4 pl-8 py-2 text-right text-sm font-iransans-thin placeholder-coral outline-none bg-lime-100"
                    placeholder="جستجوی محصول یا دسته‌بندی..."
                    x-model="searchQuery"
                >

                <!-- دکمه پاک کردن -->
                <button
                    x-show="searchQuery"
                    @click="searchQuery = ''; showSearch = false"
                    class="px-3 text-gray-500 hover:text-red-500 transition text-xl"
                    aria-label="پاک کردن جستجو"
                >
                    &times;
                </button>
            </div>
        </div>
        @guest()
            <div dir="rtl" class="absolute bottom-0 right-0 w-full bg-coral-body p-1 mt-2 font-iransans-thin text-[10px] color-coral text-right">جهت ثبت سفارش لطفا بارکد  روی میز را اسکن کنید</div>
        @endguest
    </header>


    <!--  دسته بندی ها مودال تمام‌صفحه -->
    <div
        x-show="showCategories"
        x-cloak
        x-transition
        class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-center p-8"
        @click.away="showCategories = false"
    >
        <!-- دکمه بستن -->
        <button @click="showCategories = false" class="absolute top-4 left-4 text-3xl text-coral hover:text-red-500 transition" aria-label="بستن">
            &times;
        </button>

        <!-- عنوان مودال -->
        <h2 class="text-xl font-iransans-bold mb-4 text-coral">لیست دسته‌بندی‌ها</h2>

        <!-- لیست دسته‌بندی‌ها -->
        <div class="flex flex-col space-y-4 w-full max-w-md text-center overflow-y-auto max-h-[70vh]">
            <template x-for="cat in categories" :key="cat.id">
                <div
                    class="w-52 mx-auto font-iransans-thin text-lg text-black py-2 px-4 border-b border-black cursor-pointer hover:bg-gray-200 transition"
                    @click="scrollToCategory(cat.id); showCategories = false"
                    x-text="cat.name"
                ></div>
            </template>
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
                <div class="relative border-b border-black flex py-4 cursor-pointer" @click="openModal('Product', product)">

                    <div class="relative" >
                        @auth()
                        <!-- آیکون قلب -->
                        <button wire:loading.remove
                            @click.stop="toggleFavoriteJS(product.id)"
                            class="absolute top-1 right-1 text-coral hover:text-red-500 transition"
                            aria-label="افزودن به علاقه‌مندی‌ها">
                            <template x-if="product.is_favorite">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" width="48" height="48" class="w-5 h-5">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                                       2 5.42 4.42 3 7.5 3
                                       c1.74 0 3.41.81 4.5 2.09
                                       C13.09 3.81 14.76 3 16.5 3
                                       19.58 3 22 5.42 22 8.5
                                       c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>

                            </template>
                            <template x-if="!product.is_favorite">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M21.8 7.3c0 4.6-9.8 11.2-9.8 11.2S2.2 11.9 2.2 7.3C2.2 4.6 4.6 2.2 7.3 2.2c1.7 0 3.3.8 4.3 2 1-1.2 2.6-2 4.3-2 2.7 0 5.1 2.4 5.1 5.1z"/>
                                </svg>
                            </template>
                        </button>
                        @endauth
                        <!-- تصویر محصول -->
                        <img :src="product.image_url || '/images/category.jpg'" :alt="product.name"
                             class="h-36 w-36 rounded-2xl shadow" loading="lazy">
                    </div>

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
    <div
        x-show="showProduct" x-cloak x-transition
        class="fixed inset-0 z-50 flex items-center justify-center pt-16 pb-16 overflow-auto bg-coral-body"
        @click.away="closeModal('Product')"
         dir="rtl"
         @close-modal.window="(event.detail.includes('productModal')) ? closeModal('Product') : null"
    >
        <livewire:back modal="productModal" />
        <div class="relative bg-coral-body rounded-lg w-full max-w-3xl mx-auto mt-16 px-6 py-12 overflow-y-auto max-h-screen"
            @click.stop>

            <!-- دکمه بستن خارج از تصویر و با فاصله مناسب از بالا -->
            <button @click="closeModal('Product')"
                    class="absolute top-4 right-4 text-coral hover:text-red-500 text-3xl font-bold z-10">
                &times;
            </button>

            <!-- ظرف تصویر با نسبت 16:9 -->
            <div class="relative aspect-video w-full mb-4 rounded-lg overflow-hidden">                
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
            <button @click="closeModal('Product')"
                    class="text-white w-full bg-coral py-2 mb-16 px-5 rounded mt-10 font-iransans-thin transition">
                بازگشت
            </button>
        </div>
    </div>


    <!--  خانه مودال تمام صفحه -->
        <div
            x-show="showHome"
            x-cloak
            x-transition
            class="fixed inset-0 z-50 flex flex-col items-center justify-between p-8 bg-coral-body"
            @click.away="closeModal('Home')"
        >
            <!-- عنوان وسط صفحه -->
            <div class="flex-grow flex flex-col items-center justify-center">
                <img class="w-48" src="/images/coral-logo.png" alt="logo">
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
                        @click="closeModal('Home')"
                    >
                        مشاهده منوی دیجیتال
                    </button>
                    <button
                        class="text-coral border border-coral py-3 rounded font-iransans-thin"
                        @click="openModal('WorkHours')"
                    >
                        ساعت کار
                    </button>
                    <button
                        class="text-coral border border-coral py-3 rounded font-iransans-thin"
                        @click="openModal('About')"
                    >
                        درباره ما
                    </button>
                    <button
                        class="text-coral border border-coral py-3 rounded font-iransans-thin"
                        @click="openModal('Contact')"
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
                    @close-modal.window="(event.detail.includes('Contact')) ? closeModal('Contact') : null"
                    class="fixed inset-0 bg-coral-body z-50 flex flex-col max-h-screen overflow-y-auto px-6 py-10"
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

    @auth
        <livewire:coral.ai/>
        <button
            @click="showFavoritesOnly = !showFavoritesOnly"
            class="fixed flex justify-center items-center left-0 rounded-tr-xl bg-coral text-white shadow-lg hover:bg-orange-500 transition"
            style="bottom: 8.4rem;padding: 0.75rem 0.875rem"

        >
            <!-- آیکون -->
            <svg xmlns="http://www.w3.org/2000/svg" :fill="showFavoritesOnly ? 'red' : 'none'" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.8 7.3c0 4.6-9.8 11.2-9.8 11.2S2.2 11.9 2.2 7.3C2.2 4.6 4.6 2.2 7.3 2.2c1.7 0 3.3.8 4.3 2 1-1.2 2.6-2 4.3-2 2.7 0 5.1 2.4 5.1 5.1z"/>
            </svg>
            @if($favoritesCount)
                <span class="farsi-number font-iransans-bold absolute left-2 top-1 text-[9px]">
                    {{ $favoritesCount }}
                </span>
            @endif

        </button>
        <livewire:coral.user-area/>
        <livewire:coral.cart-area/>
        <livewire:call-waiter/>
    @endauth
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('menuApp', (categories, productsByCategory) => ({
        categories,
        productsByCategory,
        searchQuery: '',
        showSearch: false,
        showModal: false,
        showHome: false,
        showProduct: false,
        showWorkHours: false,
        showAbout: false,
        showContact: false,
        showCategories: false,
        showFavoritesOnly: false,
        activeCategory: categories[0]?.id || null,
        selectedProduct: {},
        cart: [],
        
        init() {
            const savedCart = localStorage.getItem('cart');
            if (savedCart) {
                this.cart = JSON.parse(savedCart);
            }
            if (window.location.search.includes('page=menu')) {
                this.showHome = false;
            }
            this.setupCategoryObserver();
        },

        get filteredProducts() {
            let data = this.productsByCategory;
            if (this.searchQuery.trim()) {
                const q = this.searchQuery.toLowerCase();
                data = data.map(g => {
                    const filtered = g.products.filter(p =>
                        p.name.toLowerCase().includes(q) ||
                        (p.description && p.description.toLowerCase().includes(q))
                    );
                    return filtered.length ? { ...g, products: filtered } : null;
                }).filter(Boolean);
            }
            if (this.showFavoritesOnly) {
                data = data.map(g => {
                    const filtered = g.products.filter(p => p.is_favorite);
                    return filtered.length ? { ...g, products: filtered } : null;
                }).filter(Boolean);
            }
            return data;
        },

        setupCategoryObserver() {
            setTimeout(() => {
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const catId = entry.target.getAttribute('data-cat');
                            if (catId) {
                                this.activeCategory = Number(catId);
                                const nav = document.querySelector(`[data-nav-cat='${catId}']`);
                                nav?.scrollIntoView({ behavior: 'smooth', inline: 'center' });
                            }
                        }
                    });
                }, { threshold: 0.5 });
                document.querySelectorAll('.category-section').forEach(el => observer.observe(el));
            }, 300);
        },

        scrollToCategory(catId) {
            this.showModal = false;
            setTimeout(() => {
                const el = document.querySelector(`[data-cat='${catId}']`);
                if (el) {
                    const offset = el.getBoundingClientRect().top + window.scrollY - 180;
                    window.scrollTo({ top: offset, behavior: 'smooth' });
                }
            }, 300);
        },

        openModal(name, data = null) {
            this[`show${name}`] = true;
            if (data !== null) this[`selected${name}`] = data;
        },

        closeModal(name) {
            this[`show${name}`] = false;
            if (this.hasOwnProperty(`selected${name}`)) this[`selected${name}`] = {};
        },

        updateCart(product, diff) {
            let item = this.cart.find(i => i.id === product.id);
            if (item) {
                item.quantity += diff;
                if (item.quantity <= 0) {
                    this.cart = this.cart.filter(i => i.id !== product.id);
                }
            } else if (diff > 0) {
                this.cart.push({ ...product, quantity: diff });
            }
            localStorage.setItem('cart', JSON.stringify(this.cart));
        },

        addToCart(p) { this.updateCart(p, 1); },
        increaseQuantity(p) { this.updateCart(p, 1); },
        decreaseQuantity(p) { this.updateCart(p, -1); },

        isInCart(id) { return this.cart.some(i => i.id === id); },
        productQuantity(id) {
            let i = this.cart.find(i => i.id === id);
            return i ? i.quantity : null;
        },

        formatPrice(price) {
            if (typeof price !== 'number' || isNaN(price)) return '۰';
            return price.toLocaleString('fa-IR');
        },

        toggleFavoriteJS(productId) {
            if (!productId) return;
            this.$wire.toggleFavorite(productId).then(() => {
                for (const g of this.productsByCategory) {
                    const p = g.products.find(p => p.id === productId);
                    if (p) {
                        p.is_favorite = !p.is_favorite;
                        break;
                    }
                }
            });
        }
    }));
});
</script>
@endpush

