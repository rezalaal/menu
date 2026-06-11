<div class="min-h-screen bg-coral-body flex flex-col" dir="rtl">
    <livewire:back to="/?page=menu" />

    <div class="flex-1 p-4 pt-20 max-w-3xl mx-auto w-full">
        <div class="relative rounded-3xl overflow-hidden mb-4 shadow-soft">
            <div class="aspect-video">
                <img src="{{ $product->getFirstMediaUrl() ?: asset('images/placeholder.png') }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-cover" />
            </div>
        </div>

        <div class="card-coral p-5 mb-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-iransans-thin text-xl text-coral-from">{{ $product->name }}</h2>
                <span class="font-iransans-regular farsi-number text-sm px-3 py-1 rounded-full bg-coral/15 text-coral-from">
                    {{ number_format($product->price) }} تومان
                </span>
            </div>
            <div class="font-iransans-thin text-sm text-coral-from/70 leading-relaxed">
                {!! Str::markdown(strip_tags($product->description)) !!}
            </div>
        </div>

        <div class="card-coral p-4 sticky bottom-0">
            <button onclick="window.location.href='/?page=menu'"
                class="btn-secondary w-full py-2.5 rounded-xl text-sm">
                بازگشت
            </button>
        </div>
    </div>
</div>
