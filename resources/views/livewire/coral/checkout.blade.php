<div class="p-4 max-w-screen-md mx-auto pb-32" dir="rtl">
    <div class="bg-gradient-brand rounded-3xl shadow-soft p-6 mb-6 text-center">
        <h1 class="font-dastnevis text-2xl text-white text-shadow">لیست سفارش‌های در حال پردازش</h1>
    </div>

    <livewire:back to="/?page=menu"/>

    @if ($orders->isEmpty())
        <div class="card-coral p-8 text-center mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-coral-from/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m-7 4h14a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <p class="font-iransans-thin text-coral-from/50">شما هیچ سفارش در حال پردازشی ندارید.</p>
        </div>
    @else
        @foreach ($orders as $order)
            <div class="card-coral p-4 mb-4 animate-fade-in-up">
                <div class="flex items-center justify-between mb-3 bg-gradient-to-r from-coral-from/10 to-transparent p-3 rounded-2xl">
                    <div class="farsi-number font-iransans-bold text-coral-from text-sm">کد سفارش: {{ $order->id }}</div>
                    <div class="farsi-number font-iransans-thin text-xs text-coral-from/50">{{ verta($order->created_at)->format('Y/m/d H:i') }}</div>
                </div>

                <div class="font-iransans-thin text-xs text-coral-from/60 mb-2">
                    {{ $order->table?->name ?? 'بدون میز' }}
                </div>

                <ul class="text-sm space-y-2">
                    @foreach ($order->orderLines as $line)
                        <li class="flex items-center justify-between border-b border-coral/10 pb-2">
                            <span class="font-iransans-regular text-coral-from/80">{{ $line->product->name }}</span>
                            <div class="flex items-center gap-3">
                                <span class="farsi-number font-iransans-bold text-coral-from/60 text-xs">×{{ $line->qty }}</span>
                                <span class="farsi-number font-iransans-bold text-coral-from text-xs">{{ number_format($line->price * $line->qty) }} تومان</span>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="flex items-center justify-between mt-4 p-3 bg-coral/10 rounded-2xl">
                    <span class="font-iransans-thin text-coral-from/70 text-sm">جمع کل:</span>
                    <span class="font-iransans-bold farsi-number text-coral-from">{{ number_format($order->total) }} تومان</span>
                </div>

                <div class="flex items-center gap-3 mt-3">
                    <button
                        wire:loading.remove
                        wire:click="postPay({{ $order->id }})"
                        class="btn-secondary flex-1 py-2 rounded-xl text-sm"
                    >
                        پس پرداخت
                    </button>

                    <button
                        wire:loading.remove
                        wire:click="cancelOrder({{ $order->id }})"
                        class="flex items-center justify-center px-3 py-2 rounded-xl border-2 border-red-200 text-red-400 hover:bg-red-50 hover:border-red-400 transition text-sm"
                        title="انصراف از سفارش"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"/>
                        </svg>
                    </button>
                </div>

                <button
                    wire:loading
                    class="btn-secondary w-full py-2 rounded-xl text-sm mt-3 opacity-70 cursor-not-allowed"
                >
                    در حال پردازش
                </button>
            </div>
        @endforeach
    @endif
</div>
