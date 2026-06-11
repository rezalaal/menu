<div class="p-4 max-w-screen-md mx-auto pb-32" dir="rtl">
    <div class="bg-gradient-brand rounded-3xl shadow-soft p-6 mb-6 text-center">
        <h1 class="font-dastnevis text-2xl text-white text-shadow">لیست سفارش‌ها</h1>
    </div>

    <livewire:back to="/?page=menu"/>

    @if ($orders->isEmpty())
        <div class="card-coral p-8 text-center mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-coral-from/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
            </svg>
            <p class="font-iransans-thin text-coral-from/50">شما هیچ سفارش در حال پردازشی ندارید.</p>
        </div>
    @else
        @foreach ($orders as $order)
            <div class="card-coral p-4 mb-4 animate-fade-in-up">
                <div class="flex items-center justify-between mb-3 bg-gradient-to-r from-coral-from/10 to-transparent p-3 rounded-2xl">
                    <div class="farsi-number font-iransans-bold text-coral-from text-sm">کد سفارش: {{ $order->id }}</div>
                    <div class="text-xs font-iransans-thin px-3 py-1 rounded-full bg-coral text-white shadow-soft">
                        {{ $order->status->getLabel() }}
                    </div>
                    <div class="farsi-number font-iransans-thin text-xs text-coral-from/50">
                        {{ verta($order->created_at)->format('Y/m/d H:i') }}
                    </div>
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
