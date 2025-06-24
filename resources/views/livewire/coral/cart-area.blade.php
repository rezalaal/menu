<div class="relative flex flex-col items-center justify-center mt-6" id="cart-icon">
    <div>
        <button    
            class="fixed flex justify-center items-center bottom-14 left-0 rounded-tr-xl bg-coral text-white p-3 shadow-lg hover:bg-orange-500 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
            <span wire:loading class="font-dastnevis">لطفا صبر کنید.</span>
            <span id="cart-number" class="farsi-number font-iransans-bold absolute left-2 top-1 text-[9px]"></span>
        </button>        
    </div>
    <div id="cart-modal" class="fixed inset-0 bg-white z-50 flex-col max-h-screen overflow-y-auto px-6 py-10 hidden">

        <h3 class="font-iransans-extrabold text-center text-coral text-3xl"> سبد خرید </h3>

        <button
            class="text-coral border border-coral py-2 px-5 rounded mt-10 font-iransans-thin hover:bg-coral hover:text-white transition"
            id="cart-back"
        >
            بازگشت به خانه
        </button>
    </div>
</div>
@push('scripts')
<script>    
    setInterval(() => {
        cartNumberEl = document.querySelector("#cart-number")
        const cartData = localStorage.getItem('cart');
        if (cartData) {
            const cartItems = JSON.parse(cartData);
            const cartCount = cartItems.length;
            cartNumberEl.innerText = cartCount !== 0 ? cartCount : '';
        } else {
            cartNumberEl.innerText = '';
        }
        
    }, 1000)

    cartIcon = document.querySelector("#cart-icon")
    cartModal = document.querySelector("#cart-modal")    
    cartBack = document.querySelector("#cart-back")

    cartIcon.addEventListener('click', () => {        
        cartModal.classList.add('visible');
        cartModal.classList.remove('hidden');
    });

    cartBack.addEventListener('click', () => {
        console.log('clicked', cartModal.classList)
        cartModal.classList.add('hidden');
        cartModal.classList.remove('visible');        
    });
</script>
@endpush