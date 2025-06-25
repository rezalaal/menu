    <div class="p-4 max-w-screen-md mx-auto" dir="rtl">
        <div class="fixed top-4 left-4 z-50 cursor-pointer" onclick="window.history.back()">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-coral hover:text-orange-500 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" >
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
    </div>

    <h1 class="text-xl font-iransans-bold text-coral mb-6 text-center">لیست سفارش‌های در حال پردازش</h1>

    @if ($orders->isEmpty())
        <div class="text-center text-gray-500 font-iransans-bold">
            شما هیچ سفارش در حال پردازشی ندارید.
        </div>
    @else
        @foreach ($orders as $order)
            <div class="border rounded-xl mb-6 shadow-xl p-4">
                <div class="flex justify-between mb-2">
                    <div class="farsi-number font-iransans-bold text-gray-700">کد سفارش: {{ $order->id }}</div>
                    <div class="farsi-number font-iransans-thin text-sm text-gray-500">{{ verta($order->created_at)->format('Y/m/d H:i') }}</div>
                </div>

                <div class="font-iransans-thin mb-2 text-sm text-gray-600">
                    {{ $order->table?->name ?? 'بدون میز' }}
                </div>

                <ul class="text-sm text-gray-700 space-y-2 mt-4">
                    @foreach ($order->orderLines as $line)
                        <li class="flex justify-between items-center border-b pb-2">
                            <span class="font-iransans-regular">{{ $line->product->name }}</span>
                            <span class="farsi-number font-iransans-bold">×{{ $line->qty }}</span>
                            <span class="farsi-number font-iransans-bold">{{ number_format($line->price * $line->qty) }} تومان</span>
                        </li>
                    @endforeach
                </ul>

                <div class="flex justify-center mt-4 p-4 text-right font-iransans-bold text-coral bg-gray-200">
                    جمع کل: <span class="farsi-number font-iransans-bold">{{ number_format($order->total) }}</span> تومان
                </div>

                <div class="flex items-center justify-between gap-4 mt-2">
                    <!-- دکمه پس پرداخت -->
                    <button
                        wire:loading.remove
                        wire:click="postPay({{ $order->id }})"
                        class="flex-1 bg-coral text-white font-iransans-thin py-2 px-4 rounded shadow hover:bg-orange-500 transition"
                    >
                        پس پرداخت
                    </button>

                    <!-- دکمه انصراف -->
                    <button
                        wire:click="cancelOrder({{ $order->id }})"
                        class="flex items-center justify-center px-3 py-2 rounded border border-red-400 text-red-500 hover:bg-red-100 transition"
                        title="انصراف از سفارش"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"
                            />
                        </svg>
                    </button>
                </div>

                <button
                    wire:loading
                    class="bg-coral text-white font-iransans-thin mt-4 py-2 px-4 rounded shadow hover:bg-orange-500 transition w-full"
                >
                    در حال پردازش
                </button>
            </div>
        @endforeach
    @endif
</div>
