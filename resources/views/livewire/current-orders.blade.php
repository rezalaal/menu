<div class="p-4 text-white">
<span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>
    @foreach($orders as $order)
        <div wire:click="order({{$order->id}})" class="cursor-pointer flex flex-col p-4 gap-2 text-2xl bg-lime-100 mt-4 text-lime-950 font-dastnevis rounded-2xl shadow-xl">
            <div class="flex flex-row justify-between items-center">
                <span>تاریخ</span>
                <span>{{ verta($order->created_at)->format("Y/m/d") }}</span>
            </div>
            <div class="flex flex-row justify-between items-center">
                <span>ساعت</span>
                <span>{{ verta($order->created_at)->format("H:i") }}</span>
            </div>
            <div class="flex flex-row justify-between items-center">
                <span>جمع مبلغ</span>
                <span>{{ number_format($order->total) }} تومان</span>
            </div>
            <div class="flex flex-row justify-between items-center">
                <span>وضعیت</span>
                <span>{{ $order->status }}</span>
            </div>
            <div class="flex flex-row justify-between items-center">
                <span>میز</span>
                <span>{{ $order->table->name }}</span>
            </div>
        </div>
    @endforeach
</div>
