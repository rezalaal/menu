<div
    x-data="cart"
    x-init="startWatcher()"
    class="relative flex flex-col items-center justify-center mt-6"
>
    <!-- دکمه سبد خرید -->
    <div>
        <button
            @click="showModal = true"
            class="fixed flex justify-center items-center bottom-14 left-0 rounded-tr-xl bg-coral text-white p-3 shadow-lg hover:bg-orange-500 transition"
        >
            <!-- آیکون -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3
                    2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6
                    20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5
                    0 .75.75 0 0 1 1.5 0Z"
                />
            </svg>
            <span x-show="cartCount > 0" x-text="cartCount"
                class="farsi-number font-iransans-bold absolute left-2 top-1 text-[9px]"
            ></span>
        </button>
    </div>

    <!-- مودال سبد خرید -->
    <div
        x-show="showModal"
        x-transition
        class="fixed inset-0 bg-white z-50 flex flex-col max-h-screen overflow-y-auto px-6 py-10"
        style="display: none;"
    >
        <h3 class="font-iransans-extrabold text-center text-coral text-3xl mb-6">سبد خرید</h3>

        <template x-if="items.length === 0">
            <p class="text-center text-gray-500 font-iransans-bold">سبد خرید شما خالی است.</p>
        </template>

        <template x-for="item in items" :key="item.id">
            <div dir="rtl" class="relative flex items-center justify-between border-b px-4 py-2 gap-4 shadow-sm shadow-coral rounded mt-4">

                <!-- دکمه حذف -->
                <button
                    @click="removeItem(item.id)"
                    class="absolute top-1 left-1 text-coral transition"
                    title="حذف"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- تصویر محصول -->
                <div class="w-16 h-16 flex-shrink-0">
                    <img
                        :src="item.image_url || '/images/category.jpg'"
                        alt=""
                        class="w-full h-full object-cover rounded"
                    >
                </div>

                <!-- اطلاعات محصول -->
                <div class="flex-1 flex flex-col justify-between text-right">
                    <h4 class="font-iransans-bold text-[11px] text-gray-800 mb-1" x-text="item.name"></h4>

                    <div class="farsi-number text-coral text-[11px] font-iransans-bold mb-1">
                        <span class="farsi-number font-iransans-bold" x-text="formatPrice(item.price)"></span> تومان
                    </div>

                    <div class="flex items-center gap-1 mt-1">

                        <!-- دکمه افزایش -->
                        <button
                            wire:loading.remove
                            @click="increaseQuantity(item)"
                            class="bg-coral hover:bg-gray-300 text-white hover:text-black rounded w-6 h-6 text-sm font-bold"
                        >+</button>

                        <!-- عدد -->
                        <span class="farsi-number font-iransans-bold text-sm w-4 text-center" x-text="item.quantity"></span>

                        <!-- دکمه کاهش -->
                        <button
                            wire:loading.remove
                            @click="decreaseQuantity(item)"
                            class="bg-coral hover:bg-gray-300 text-white hover:text-black rounded w-6 h-6 text-sm font-bold"
                            :disabled="item.quantity <= 1"
                        >−</button>

                    </div>

                </div>
            </div>
        </template>

        <template x-if="items.length > 0">
            <div>
                <!-- جمع کل -->
                <div class="pt-2 mt-6 text-lg text-right text-gray-800 font-iransans-bold">
                    جمع کل: <span class="farsi-number font-iransans-bold" x-text="formatPrice(totalPrice)"></span> تومان
                </div>

                <div class="text-coral text-center p-4 font-iransans-bold">
                    @error('cart') {{ $message }} @enderror
                </div>

                <!-- دکمه نهایی سازی -->
                <button
                    wire:loading.remove
                    @click="finalizeOrder()"
                    class="w-full bg-coral text-white font-iransans-thin mt-6 py-2 px-4 rounded shadow hover:bg-orange-500 transition"
                >
                    نهایی‌سازی سفارش
                </button>

                <div wire:loading class="font-iransans-regular text-base text-center text-coral mt-6 py-2 px-4 transition">
                    در حال ثبت سفارش
                </div>
            </div>
        </template>


        <!-- دکمه برگشت -->
        <button
            @click="showModal = false"
            class="text-coral border border-coral py-2 px-5 rounded mt-4 font-iransans-thin hover:bg-coral hover:text-white transition"
        >
            بازگشت
        </button>
    </div>
</div>


@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cart', () => ({
        items: [],
        cartCount: 0,
        showModal: false,
        intervalId: null,

        startWatcher() {
            this.loadCart();
            this.intervalId = setInterval(() => this.loadCart(), 1000);

            Livewire.on('order-finalized', () => {
                localStorage.removeItem('cart');
                window.location.href = '/checkout';
            });
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

        get totalPrice() {
            return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },

        formatPrice(price) {
            if (typeof price !== 'number' || isNaN(price)) {
                return '۰';
            }
            return price.toLocaleString('fa-IR');
        },


        finalizeOrder() {
            const payload = this.items.map(item => ({
                product_id: item.id,
                quantity: item.quantity
            }));

            Livewire.dispatch('finalize-order', { items: payload });
        },

        removeItem(id) {
            this.items = this.items.filter(item => item.id !== id);
            localStorage.setItem('cart', JSON.stringify(this.items));
            this.cartCount = this.items.length;
        }


    }));
});
</script>

@endpush
