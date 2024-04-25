<div dir="rtl" class="bg-gradient-to-b from-coral-from to-coral-to h-screen pb-48 flex flex-col items-center">
    <h1 class="font-dastnevis text-3xl mt-10 px-4 text-white">پروفایل</h1>
    <div class="avatar flex justify-center mt-4">
        <div class="w-80 h-80 rounded-full">
            <svg class="text-lime-950" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </div>        
    </div>
    @if (auth()->user())
        <span class="farsi-number text-center w-full text-3xl pt-4">{{ auth()?->user()->username}}</span>    
        <button class="cursor-pointer" wire:click="logoff">خروج</button>
    @else
        <livewire:login-form>
    @endif
    
    <livewire:footer-menu>
</div>