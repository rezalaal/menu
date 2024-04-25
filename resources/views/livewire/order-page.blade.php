<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-full pb-48 flex flex-col md:items-center">
        <h1 class="font-dastnevis text-3xl font-black mt-10 px-4 text-white">سفارشات </h1>
    <livewire:search-input />
    <div class="mt-4 text-white font-dastnevis text-sm flex flex-row justify-center items-center">
        <button class="px-6 rounded-t-xl @if($tab == 'previous') bg-lime-950 border-b-lime-400 border-b-4 pb-1 @else bg-lime-900 pb-2 @endif " wire:click="switch('prev')">سفارشات پیشین</button>
        <button class="px-6 rounded-t-xl @if($tab == 'current') bg-lime-950 border-b-lime-400 border-b-4 pb-1 @else bg-lime-900  pb-2 @endif" wire:click="switch('curr')">سفارشات جاری</button>
    </div>
    <div class="flex flex-col bg-lime-950 mx-4 rounded-3xl pb-36">     
    <span wire:loading class="loading loading-dots loading-lg pt-2 text-white"></span>         
        
        @if ($tab == "current")              
            <livewire:current-orders>          
        @else                   
            <livewire:previous-orders>
        @endif
    </div>
    <livewire:footer-menu />
</div>
