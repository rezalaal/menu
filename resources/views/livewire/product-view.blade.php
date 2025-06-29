<div        
        class="fixed inset-0 z-50 flex items-center justify-center pt-16 pb-16 overflow-auto bg-coral-body"
        dir="rtl"
    >
        <livewire:back to="/?page=menu" />
        <div class="relative bg-coral-body rounded-lg w-full max-w-3xl mx-auto mt-16 px-6 py-12 overflow-y-auto max-h-screen">            

            <!-- ظرف تصویر با نسبت 16:9 -->
            <div class="relative aspect-video w-full mb-4 rounded-lg overflow-hidden">                
                <img src="{{ $product->getFirstMediaUrl() ?: config('app.url').'/images/category.jpg' }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover shadow" />
            </div>


            <!-- عنوان، قیمت و توضیح -->
            <h2 class="text-xl font-iransans-thin mb-2 text-center">{{ $product->name }}</h2>
            <p class="text-center font-iransans-regular farsi-number mb-4">
                {{ number_format($product->price) }} تومان   
            </p>
            <div>
                {!! Str::markdown(strip_tags($product->description)) !!}
            </div>

            <!-- دکمه بازگشت -->
            <button onclick="window.location.href='/?page=menu'"  class="text-white w-full bg-coral py-2 mb-16 px-5 rounded mt-10 font-iransans-thin transition">
                بازگشت
            </button>
        </div>
</div>
