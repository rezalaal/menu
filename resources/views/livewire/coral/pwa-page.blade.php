<div>
     <header class="fixed top-0 left-0 flex flex-col items-center w-full pt-1 bg-white pb-4">
         <div class="w-full font-iransans-extrabold relative flex items-center justify-start px-4 h-16">
             <!-- آیکون سمت چپ -->
             <div class="text-coral">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-coral size-6">
                     <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                 </svg>
             </div>

             <!-- متن وسط صفحه -->
             <div class="absolute inset-0 flex justify-center items-center pointer-events-none">
                 <div class="text-3xl">{{ $settings['init_site_name'] }}</div>
             </div>
         </div>

         <div class="flex text-2xl scroll-smooth snap-start overflow-x-auto max-w-full box-border m-4 no-scrollbar">
             @foreach($categories as $category)
                 <span class="font-iransans-thin text-black text-sm cursor-pointer px-4 py-2 flex flex-row mx-2 whitespace-nowrap">{{ $category['name'] }}</span>
             @endforeach
         </div>
         <button class="bg-coral text-white text-xl shadow px-6 pb-1"> همه دسته بندی ها</button>
     </header>
    <div class="pt-44 w-full px-4 mb-4" dir="rtl">
        @foreach($products as $product)
            <div class="border-b border-black flex py-4">
                <div>
                    <img src="{{ $product['image_url'] }}" alt="$product->name" class="h-36 rounded-2xl shadow">
                </div>
                <div class="p-4">
                    <h3 class="pb-2 text-2xl font-iransans-ultralight">{{ $product['name'] }}</h3>
                    <span class="font-iransans-extrabold farsi-number">{{ $product['price'] }} تومان</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
