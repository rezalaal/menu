<div wire:init="loadData" class="w-full min-h-screen bg-coral-body flex flex-col">
    <div id="loading" class="flex hidden flex-col justify-center items-center flex-1 min-h-screen">
        <img class="w-32 animate-float" src="/images/coral-logo.png" alt="logo">
        <div dir="rtl" class="p-4 text-center text-coral-from font-iransans-thin animate-pulse">
            لطفا تا زمان بارگزاری کامل صبر کنید
        </div>
    </div>

    @if (empty($categories))
        <div class="flex flex-col justify-center items-center flex-1 min-h-screen">
            <img class="w-32 animate-float" wire:loading src="/images/coral-logo.png" alt="logo">
            <div wire:loading dir="rtl" class="p-4 text-center text-coral-from font-iransans-thin animate-pulse">
                لطفا تا زمان بارگزاری کامل صبر کنید
            </div>
        </div>
    @else
        <div
            x-data="menuApp({{ Js::from($categories) }}, {{ Js::from($productsByCategory) }})"
            x-init="init()"
            wire:loading.remove
            class="flex flex-col flex-1 max-w-screen-sm mx-auto"
        >
            <!-- HEADER FIXED با طراحی مدرن -->
            <header class="fixed top-0 left-0 right-0 z-40 max-w-screen-sm mx-auto">
                <div class="bg-coral-header/90 backdrop-blur-lg rounded-b-3xl shadow-soft px-4 pt-3 pb-2 {{ auth()->check() ? '' : 'pb-4' }}">

                    <!-- ردیف بالا: لوگو، عنوان، سرچ -->
                    <div class="flex items-center justify-between">
                        <div class="text-coral-from cursor-pointer hover:scale-110 transition-transform" @click="openModal('Home')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                            </svg>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="text-lg font-dastnevis text-coral-from">{{ $settings['init_site_name'] }}</span>
                        </div>

                        <button class="text-coral-from hover:scale-110 transition-transform" @click="showSearch = !showSearch">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M15.75 10.5a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"/>
                            </svg>
                        </button>
                    </div>

                    <!-- نوار دسته‌بندی pills -->
                    <div class="w-full overflow-x-auto no-scrollbar mt-2" x-show="!showSearch">
                        <div class="flex w-max items-center gap-2 py-1">
                            <template x-for="cat in categories" :key="cat.id">
                                <span
                                    :data-nav-cat="cat.id"
                                    @click="scrollToCategory(cat.id)"
                                    :class="activeCategory == cat.id
                                        ? 'bg-coral text-white shadow-glow scale-105 font-iransans-bold'
                                        : 'bg-white/60 text-coral-from/70 hover:bg-white hover:text-coral-from font-iransans-thin'"
                                    class="cursor-pointer px-4 py-1.5 rounded-full text-sm whitespace-nowrap transition-all duration-300"
                                    x-text="cat.name"
                                ></span>
                            </template>
                        </div>
                    </div>

                    <!-- دکمه همه دسته‌بندی‌ها -->
                    <div class="flex items-center mt-1.5" x-show="!showSearch">
                        <button @click="showCategories = true"
                            class="flex items-center gap-1.5 text-[11px] font-iransans-thin text-coral-from/50 hover:text-white bg-coral-from/20 hover:bg-coral-from/40 backdrop-blur-sm px-3 py-1 rounded-full transition-all duration-300 border border-coral-from/10 hover:border-coral-from/20">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                            </svg>
                            <span>همه دسته‌بندی‌ها</span>
                        </button>
                    </div>

                    <!-- جستجو -->
                    <div x-show="showSearch" class="mt-2" dir="rtl">
                        <div class="relative">
                            <input
                                type="text"
                                class="w-full pr-10 pl-4 py-2.5 text-right text-sm font-iransans-thin bg-white/80 rounded-2xl border-2 border-coral/30 outline-none focus:border-coral focus:shadow-glow transition-all duration-300"
                                placeholder="جستجوی محصول یا دسته‌بندی..."
                                x-model="searchQuery"
                            >
                            <button
                                x-show="searchQuery"
                                @click="searchQuery = ''; showSearch = false"
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-400 transition text-lg"
                            >
                                &times;
                            </button>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-coral/50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M15.75 10.5a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z"/>
                            </svg>
                        </div>
                    </div>

                    @guest()
                        <div dir="rtl" class="mt-2 bg-coral-amber/40 backdrop-blur-sm rounded-xl px-3 py-1.5 text-[10px] text-coral-from/70 font-iransans-thin text-center">
                            جهت ثبت سفارش لطفا بارکد روی میز را اسکن کنید
                        </div>
                    @endguest
                </div>
            </header>

            <!-- مودال همه دسته‌بندی‌ها - طراحی مدرن -->
            <div
                x-show="showCategories"
                x-cloak
                x-transition:enter="transition-all duration-400 ease-out"
                x-transition:enter-start="opacity-0 translate-y-full"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-300 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-full"
                class="fixed inset-0 z-50 flex flex-col bg-coral-body"
                @click.away="showCategories = false"
            >
                <!-- هدر ثابت -->
                <div class="sticky top-0 z-10 bg-gradient-header/90 backdrop-blur-lg px-5 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-coral-from/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                        </svg>
                        <h2 class="text-base font-dastnevis text-coral-from">همه دسته‌بندی‌ها</h2>
                    </div>
                    <button @click="showCategories = false"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-white/60 text-coral-from hover:bg-coral hover:text-white transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- گرید دسته‌بندی‌ها با تصاویر -->
                <div class="flex-1 overflow-y-auto px-4 py-5 pb-8">
                    <div class="grid grid-cols-2 gap-4">
                        <template x-for="cat in categories" :key="cat.id">
                            <div
                                @click="scrollToCategory(cat.id); showCategories = false"
                                class="group relative rounded-2xl overflow-hidden bg-white shadow-soft hover:shadow-glow-lg cursor-pointer transition-all duration-300 hover:scale-[1.03] active:scale-[0.97]"
                            >
                                <!-- تصویر دسته‌بندی -->
                                <div class="aspect-[4/3] overflow-hidden">
                                    <img
                                        :src="cat.image_url || '/images/placeholder.png'"
                                        :alt="cat.name"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    />
                                    <!-- اوورلی ملایم روی تصویر -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
                                </div>

                                <!-- نام و تعداد محصولات -->
                                <div class="absolute bottom-0 left-0 right-0 p-3">
                                    <h3 class="text-white font-iransans-thin text-sm leading-tight drop-shadow-lg" x-text="cat.name"></h3>
                                    <span class="text-white/70 text-[10px] font-iransans-thin" x-show="cat.product_count > 0">
                                        <span x-text="cat.product_count"></span> محصول
                                    </span>
                                </div>

                                <!-- نشانه دسته فعال -->
                                <div class="absolute top-2 right-2 w-2 h-2 rounded-full"
                                    :class="activeCategory == cat.id ? 'bg-coral shadow-glow' : 'bg-white/40'">
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- اگر دسته‌ای نباشد -->
                    <div x-show="categories.length === 0" class="flex flex-col items-center justify-center py-20 text-coral-from/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="font-iransans-thin">دسته‌بندی‌ای یافت نشد</p>
                    </div>
                </div>
            </div>

            <!-- لیست محصولات -->
            <div class="pt-44 px-3 pb-28" dir="rtl">
                <template x-for="group in filteredProducts" :key="group.category.id">
                    <div :id="`category-${group.category.id}`"
                        :data-cat="group.category.id"
                        class="py-3 category-section"
                    >
                        <!-- عنوان دسته‌بندی با طراحی جدید -->
                        <div class="flex items-center gap-3 mb-4 mt-2">
                            <div class="h-0.5 flex-1 bg-gradient-to-r from-transparent via-coral/50 to-transparent"></div>
                            <h2 class="text-lg font-dastnevis text-coral-from px-3" x-text="group.category.name"></h2>
                            <div class="h-0.5 flex-1 bg-gradient-to-r from-transparent via-coral/50 to-transparent"></div>
                        </div>

                        <div class="space-y-3">
                            <template x-for="product in group.products" :key="product.id">
                                <div class="card-coral overflow-hidden flex cursor-pointer hover:scale-[1.01] active:scale-[0.99]"
                                    @click="openModal('Product', product)"
                                >
                                    <div class="relative w-28 h-28 flex-shrink-0">
                                        <img :src="product.image_url || '/images/placeholder.png'" :alt="product.name"
                                            class="w-full h-full object-cover" loading="lazy">
                                        <div class="absolute inset-0 bg-gradient-to-l from-transparent to-white/20"></div>
                                    </div>

                                    <div class="flex-1 p-3 flex flex-col justify-between min-w-0">
                                        <div>
                                            <h3 class="font-iransans-thin text-sm text-coral-from leading-relaxed line-clamp-2" x-text="product.name"></h3>
                                            <span class="font-iransans-regular text-xs farsi-number mt-1 inline-block"
                                                :class="{'text-red-400': product.price == 0, 'text-coral-to/80': product.price != 0}"
                                                x-text="product.price == 0 ? 'ناموجود' : (formatPrice(product.price) + ' تومان')">
                                            </span>
                                        </div>

                                        @auth
                                            <div class="flex items-center gap-2 mt-1">
                                                <button
                                                    x-show="!isInCart(product.id) && product.price != 0"
                                                    class="btn-secondary text-xs px-4 py-1.5 rounded-lg"
                                                    @click.stop="addToCart(product)">
                                                    + سفارش
                                                </button>

                                                <div class="flex items-center gap-1.5" x-show="isInCart(product.id) && product.price != 0">
                                                    <button
                                                        @click.stop="increaseQuantity(product)"
                                                        class="w-7 h-7 flex items-center justify-center bg-coral text-white rounded-lg hover:bg-coral-from transition text-sm font-iransans-bold">
                                                        +
                                                    </button>
                                                    <span class="min-w-[20px] text-center font-iransans-extrabold text-sm farsi-number text-coral-from" x-text="productQuantity(product.id)"></span>
                                                    <button
                                                        @click.stop="decreaseQuantity(product)"
                                                        class="w-7 h-7 flex items-center justify-center bg-coral text-white rounded-lg hover:bg-coral-from transition text-sm font-iransans-bold">
                                                        −
                                                    </button>
                                                </div>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- مودال محصول -->
            <div
                x-show="showProduct" x-cloak
                x-transition:enter="transition-all duration-300 ease-out"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-8"
                class="fixed inset-0 z-50 flex flex-col bg-coral-body overflow-y-auto"
                @close-modal.window="(event.detail.includes('productModal')) ? closeModal('Product') : null"
                dir="rtl"
            >
                <div class="sticky top-0 z-10 bg-coral-header/90 backdrop-blur-lg p-4 flex items-center">
                    <button @click="closeModal('Product')" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/60 text-coral-from hover:bg-coral hover:text-white transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <h2 class="flex-1 text-center font-dastnevis text-coral-from text-lg" x-text="selectedProduct.name"></h2>
                    <div class="w-8"></div>
                </div>

                <div class="flex-1 p-4">
                    <div class="relative rounded-3xl overflow-hidden mb-4 shadow-soft">
                        <div class="aspect-video">
                            <img :src="selectedProduct.image_url || '/images/placeholder.png'"
                                :alt="selectedProduct.name"
                                class="w-full h-full object-cover"/>
                        </div>
                    </div>

                    <div class="card-coral p-4 mb-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-iransans-thin text-lg text-coral-from" x-text="selectedProduct.name"></span>
                            <span class="font-iransans-regular farsi-number text-sm px-3 py-1 rounded-full bg-coral/15 text-coral-from"
                                x-text="selectedProduct.price == 0 ? 'ناموجود' : (formatPrice(selectedProduct.price) + ' تومان')">
                            </span>
                        </div>

                        @auth
                            <div class="flex items-center justify-center gap-3 py-2">
                                <button
                                    x-show="!isInCart(selectedProduct.id) && selectedProduct.price != 0"
                                    class="btn-secondary px-8 py-2.5 rounded-xl text-sm"
                                    @click="addToCart(selectedProduct)">
                                    افزودن به سبد خرید
                                </button>

                                <div class="flex items-center gap-3" x-show="isInCart(selectedProduct.id) && selectedProduct.price != 0">
                                    <button @click="increaseQuantity(selectedProduct)"
                                        class="w-10 h-10 flex items-center justify-center bg-coral text-white rounded-xl hover:bg-coral-from transition text-lg font-iransans-bold shadow-soft">
                                        +
                                    </button>
                                    <span class="min-w-[24px] text-center font-iransans-extrabold text-lg farsi-number text-coral-from" x-text="productQuantity(selectedProduct.id)"></span>
                                    <button @click="decreaseQuantity(selectedProduct)"
                                        class="w-10 h-10 flex items-center justify-center bg-coral text-white rounded-xl hover:bg-coral-from transition text-lg font-iransans-bold shadow-soft">
                                        −
                                    </button>
                                </div>
                            </div>
                        @endauth
                    </div>

                    <div class="card-coral p-4">
                        <p class="text-justify text-coral-from/70 font-iransans-thin text-sm leading-relaxed"
                            x-html="selectedProduct.description || 'توضیحی برای این محصول موجود نیست.'"></p>
                    </div>
                </div>

                <div class="sticky bottom-0 bg-coral-body/90 backdrop-blur-lg p-4 border-t border-coral/10">
                    <button @click="closeModal('Product')"
                        class="btn-outline w-full py-2.5 rounded-xl text-sm">
                        بازگشت
                    </button>
                </div>
            </div>

            <!-- مودال خانه تمام‌صفحه -->
            <div
                x-show="showHome"
                x-cloak
                x-transition:enter="transition-all duration-400 ease-out"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition-all duration-300 ease-in"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="fixed inset-0 z-50 flex flex-col bg-gradient-warm"
                @click.away="closeModal('Home')"
            >
                <div class="flex-1 flex flex-col items-center justify-center p-8">
                    <img class="w-40 animate-float" src="/images/coral-logo.png" alt="logo">
                    <h1 class="text-3xl font-dastnevis text-coral-from text-center mt-4 text-shadow">
                        {{ $settings['init_site_name'] }}
                    </h1>
                </div>

                <div class="w-full max-w-md mx-auto px-6 pb-10 space-y-3">
                    <button
                        class="btn-secondary w-full py-3.5 rounded-2xl text-sm"
                        @click="closeModal('Home')"
                    >
                        مشاهده منوی دیجیتال
                    </button>
                    <button
                        class="btn-outline w-full py-3 rounded-2xl text-sm"
                        @click="showSettingsModal = 'work_hours'"
                    >
                        ساعت کار
                    </button>
                    <button
                        class="btn-outline w-full py-3 rounded-2xl text-sm"
                        @click="showSettingsModal = 'about'"
                    >
                        درباره ما
                    </button>
                    <button
                        class="btn-outline w-full py-3 rounded-2xl text-sm"
                        @click="showSettingsModal = 'contact'"
                    >
                        اطلاعات تماس
                    </button>
                </div>

                <livewire:coral.settings-modal section="about" key="SettingsModalAbout" />
                <livewire:coral.settings-modal section="work_hours" key="SettingsModalWorkHours" />
                <livewire:coral.settings-modal section="contact" key="SettingsModalContact" />
            </div>

            @auth
                <livewire:coral.ai/>
                <livewire:coral.user-area/>
                <livewire:call-waiter/>

                <!-- دکمه سبد خرید شناور -->
                <div x-data="cart" x-init="startWatcher()">
                    <button
                        @click="showCart = true"
                        class="fixed flex items-center justify-center bottom-24 left-4 rounded-2xl bg-gradient-header text-coral-from p-3.5 shadow-glow-lg hover:shadow-soft hover:scale-110 active:scale-95 transition-all duration-300 z-30"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                        </svg>
                        <span x-show="cartCount > 0" x-text="cartCount"
                            class="farsi-number font-iransans-bold absolute -top-1 -right-1 bg-red-500 text-white text-[9px] rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1 shadow-lg">
                        </span>
                    </button>
                </div>

                <!-- مودال سبد خرید -->
                <div
                    x-show="showCart"
                    x-cloak
                    x-transition:enter="transition-all duration-300 ease-out"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition-all duration-200 ease-in"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-8"
                    class="fixed inset-0 z-50 flex flex-col bg-coral-body overflow-y-auto"
                    @click.away="showCart = false"
                    dir="rtl"
                >
                    <!-- هدر سبد خرید -->
                    <div class="sticky top-0 z-10 bg-coral-header/90 backdrop-blur-lg p-4 flex items-center">
                        <button @click="showCart = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/60 text-coral-from hover:bg-coral hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <h2 class="flex-1 text-center font-dastnevis text-coral-from text-lg">سبد خرید شما</h2>
                        <div class="w-8"></div>
                    </div>

                    <div class="flex-1 p-4">
                        <template x-if="cart.length === 0">
                            <div class="flex flex-col items-center justify-center mt-20 text-coral-from/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                                </svg>
                                <p class="font-iransans-thin">سبد خرید شما خالی است.</p>
                            </div>
                        </template>

                        <template x-for="item in cart" :key="item.id">
                            <div class="card-coral p-3 mb-3 flex items-center gap-3 animate-fade-in-up">
                                <button
                                    @click="updateCart(item, -item.quantity)"
                                    class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>

                                <img :src="item.image_url || '/images/placeholder.png'" alt="" class="w-14 h-14 rounded-xl object-cover shadow-soft flex-shrink-0">

                                <div class="flex-1 min-w-0">
                                    <span class="font-iransans-thin text-sm text-coral-from block truncate" x-text="item.name"></span>
                                    <span class="text-xs farsi-number font-iransans-regular text-coral-to/70" x-text="formatPrice(item.price) + ' تومان'"></span>
                                </div>

                                <div class="flex items-center gap-1.5 flex-shrink-0">
                                    <button @click="decreaseQuantity(item)" class="w-7 h-7 flex items-center justify-center bg-coral/20 text-coral-from rounded-lg hover:bg-coral hover:text-white transition text-sm">−</button>
                                    <span class="min-w-[20px] text-center font-iransans-bold text-sm farsi-number text-coral-from" x-text="item.quantity"></span>
                                    <button @click="increaseQuantity(item)" class="w-7 h-7 flex items-center justify-center bg-coral/20 text-coral-from rounded-lg hover:bg-coral hover:text-white transition text-sm">+</button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- بخش پایین سبد خرید -->
                    <div x-show="cart.length > 0" class="sticky bottom-0 bg-coral-body/90 backdrop-blur-lg border-t border-coral/10 p-4 space-y-3">
                        <div class="flex items-center justify-between px-2">
                            <span class="font-iransans-thin text-coral-from">مجموع:</span>
                            <span class="font-iransans-bold farsi-number text-coral-from text-lg" x-text="formatPrice(cart.reduce((acc, i) => acc + i.price * i.quantity, 0)) + ' تومان'"></span>
                        </div>

                        <div class="flex gap-3">
                            <button
                                wire:loading.remove
                                class="btn-secondary flex-1 py-2.5 rounded-xl text-sm"
                                @click="finalizeOrder($event)"
                                type="button"
                            >
                                ثبت نهایی سفارش
                            </button>

                            <button
                                wire:loading
                                class="flex-1 py-2.5 rounded-xl text-sm bg-coral/50 text-white font-iransans-thin cursor-not-allowed"
                                disabled
                            >
                                در حال نهایی سازی
                            </button>

                            <button
                                @click="showCart = false"
                                class="btn-outline flex-1 py-2.5 rounded-xl text-sm"
                            >
                                بازگشت
                            </button>
                        </div>
                    </div>

                    <div class="p-4" x-show="cart.length === 0">
                        <button @click="showCart = false" class="btn-outline w-full py-2.5 rounded-xl text-sm">
                            بازگشت
                        </button>
                    </div>
                </div>
            @endauth
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('menuApp', (categories = [], productsByCategory = []) => ({
        categories: categories || [],
        productsByCategory: productsByCategory || [],
        searchQuery: '',
        showSearch: false,
        showModal: false,
        showHome: false,
        showProduct: false,
        showWorkHours: false,
        showAbout: false,
        showContact: false,
        showSettingsModal: null,
        showCategories: false,
        showCart: false,
        activeCategory: (categories && categories.length > 0) ? categories[0].id : null,
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
                }, { threshold: 0.3 });
                document.querySelectorAll('.category-section').forEach(el => observer.observe(el));
            }, 300);
        },

        scrollToCategory(catId) {
            this.searchQuery = '';
            this.showSearch = false;
            this.showModal = false;
            setTimeout(() => {
                const el = document.querySelector(`[data-cat='${catId}']`);
                if (el) {
                    const offset = el.getBoundingClientRect().top + window.scrollY - 170;
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

        get cartCount() {
            return this.cart.length;
        },

        formatPrice(price) {
            if (typeof price !== 'number' || isNaN(price)) return '۰';
            return price.toLocaleString('fa-IR');
        },

        loadCart() {
            const data = localStorage.getItem('cart');
            try {
                const parsed = JSON.parse(data) || [];
                this.items = parsed;
                this.cartCount = parsed.length;
            } catch {
                this.items = [];
                this.cartCount = 0;
            }
        },

        startWatcher() {
            this.loadCart();
            this.intervalId = setInterval(() => this.loadCart(), 1000);

            Livewire.on('order-finalized', () => {
                localStorage.removeItem('cart');
                window.location.href = '/checkout';
            });
        },

        finalizeOrder(event) {
            const payload = this.cart.map(item => ({
                product_id: item.id,
                quantity: item.quantity
            }));

            Livewire.dispatch('finalize-order', { items: payload });
            document.querySelector("#loading").classList.remove("hidden")
        },
    }));
});
</script>
@endpush
