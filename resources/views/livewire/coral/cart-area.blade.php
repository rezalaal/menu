<div
    x-data="cart"
    x-init="startWatcher()"
>
    <!-- دکمه سبد خرید شناور -->
    <button
        @click="showModal = true"
        class="fixed flex items-center justify-center bottom-24 left-4 rounded-2xl bg-gradient-header text-coral-from p-3.5 shadow-glow-lg hover:shadow-soft hover:scale-110 active:scale-95 transition-all duration-300 z-30"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3
                2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6
                20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5
                0 .75.75 0 0 1 1.5 0Z"
            />
        </svg>
        <span x-show="cartCount > 0" x-text="cartCount"
            class="farsi-number font-iransans-bold absolute -top-1 -right-1 bg-red-500 text-white text-[9px] rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1 shadow-lg"
        ></span>
    </button>

    <!-- مودال سبد خرید -->
    <div
        x-show="showModal"
        x-cloak
        x-transition:enter="transition-all duration-300 ease-out"
        x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition-all duration-200 ease-in"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-8"
        @close-modal.window="(event.detail.includes('modal')) ? showModal = false : null"
        class="fixed inset-0 z-50 flex flex-col bg-coral-body overflow-y-auto"
        dir="rtl"
    >
        <!-- هدر -->
        <div class="sticky top-0 z-10 bg-coral-header/90 backdrop-blur-lg p-4 flex items-center">
            <button @click="showModal = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/60 text-coral-from hover:bg-coral hover:text-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <h2 class="flex-1 text-center font-dastnevis text-coral-from text-lg">سبد خرید</h2>
            <div class="w-8"></div>
        </div>

        <div class="flex-1 p-4">
            <template x-if="items.length === 0">
                <div class="flex flex-col items-center justify-center mt-20 text-coral-from/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                    </svg>
                    <p class="font-iransans-thin">سبد خرید شما خالی است.</p>
                </div>
            </template>

            <template x-for="item in items" :key="item.id">
                <div class="card-coral p-3 mb-3 flex items-center gap-3 animate-fade-in-up">
                    <button
                        @click="removeItem(item.id)"
                        class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <img :src="item.image_url || '/images/placeholder.png'" alt=""
                        class="w-14 h-14 rounded-xl object-cover shadow-soft flex-shrink-0">

                    <div class="flex-1 min-w-0">
                        <h4 class="font-iransans-thin text-sm text-coral-from truncate" x-text="item.name"></h4>
                        <div class="farsi-number font-iransans-regular text-xs text-coral-to/70 mt-0.5">
                            <span class="farsi-number" x-text="formatPrice(item.price)"></span> تومان
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 flex-shrink-0">
                        <button
                            wire:loading.remove
                            @click="increaseQuantity(item)"
                            class="w-7 h-7 flex items-center justify-center bg-coral/20 text-coral-from rounded-lg hover:bg-coral hover:text-white transition text-sm"
                        >+</button>
                        <span class="min-w-[20px] text-center font-iransans-bold text-sm farsi-number text-coral-from" x-text="item.quantity"></span>
                        <button
                            wire:loading.remove
                            @click="decreaseQuantity(item)"
                            class="w-7 h-7 flex items-center justify-center bg-coral/20 text-coral-from rounded-lg hover:bg-coral hover:text-white transition text-sm"
                            :disabled="item.quantity <= 1"
                        >−</button>
                    </div>
                </div>
            </template>
        </div>

        <template x-if="items.length > 0">
            <div class="sticky bottom-0 bg-coral-body/90 backdrop-blur-lg border-t border-coral/10 p-4 space-y-3">
                <div class="flex items-center justify-between px-2">
                    <span class="font-iransans-thin text-coral-from">جمع کل:</span>
                    <span class="font-iransans-bold farsi-number text-coral-from text-lg" x-text="formatPrice(totalPrice)"></span>
                </div>

                <div class="text-coral-from/60 text-xs text-center font-iransans-thin">
                    @error('cart') {{ $message }} @enderror
                </div>

                <button
                    wire:loading.remove
                    @click="finalizeOrder()"
                    class="btn-secondary w-full py-2.5 rounded-xl text-sm"
                >
                    نهایی‌سازی سفارش
                </button>

                <div wire:loading class="btn-secondary w-full py-2.5 rounded-xl text-sm text-center opacity-70 cursor-not-allowed">
                    در حال ثبت سفارش
                </div>
            </div>
        </template>

        <div class="p-4" x-show="items.length === 0">
            <button
                @click="showModal = false"
                class="btn-outline w-full py-2.5 rounded-xl text-sm"
            >
                بازگشت
            </button>
        </div>
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
