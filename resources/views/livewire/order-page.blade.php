<div class="p-4 max-w-screen-md mx-auto" dir="rtl">

    <livewire:back/>
    <h1 class="text-xl font-iransans-bold text-coral mb-6 text-center">لیست سفارش‌ها</h1>

    @if ($orders->isEmpty())
        <div class="text-center text-gray-500 font-iransans-bold">
            شما هیچ سفارش در حال پردازشی ندارید.
        </div>
    @else
        @foreach ($orders as $order)


            <div class="border rounded-xl mb-6 shadow-xl p-4">
                <div class="flex justify-between items-center mb-2 bg-coral-to p-2 rounded">
                    <div class="farsi-number font-iransans-bold text-gray-700">کد سفارش: {{ $order->id }}</div>
                    <!-- نشان وضعیت سفارش -->
                    <div class="text-xs font-iransans-thin px-3 py-1 rounded-full shadow-md bg-coral text-white">
                        {{ $order->status->getLabel() }}
                    </div>
                    <div class="farsi-number font-iransans-thin text-sm text-white">
                        {{ verta($order->created_at)->format('Y/m/d H:i') }}
                    </div>
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
