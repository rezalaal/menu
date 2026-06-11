<div wire:init="loadData" class="fixed w-full h-full bg-gradient-to-b from-coral-from to-coral-body flex flex-col justify-center items-center">

    <img class="w-32 animate-float" wire:loading src="/images/coral-logo.png" alt="logo">
    <div wire:loading dir="rtl" class="p-4 text-center text-white font-iransans-thin animate-pulse">
        لطفا تا زمان بارگزاری کامل صبر کنید
    </div>

    <div wire:loading.remove class="relative min-h-screen w-full">
        <video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover z-[-2]">
            <source src="{{ $tableVideoUrl ?? asset('videos/coral.mp4') }}" type="video/mp4">
        </video>

        <div class="fixed top-0 left-0 w-full h-full bg-gradient-to-t from-black/60 via-black/30 to-black/40 z-[-1]"></div>

        <div class="relative pb-16 min-h-screen flex flex-col justify-between items-center p-6">
            <div x-data="{ visible: false }" @click.away="visible = false" class="flex flex-col items-center mt-16 group">
                <div class="relative">
                    <img
                        @mouseenter="visible = true"
                        @mouseleave="visible = false"
                        @click="visible = !visible"
                        :class="{ 'opacity-100 scale-100': visible, 'opacity-80 scale-95': !visible }"
                        class="rounded-full w-40 h-40 shadow-2xl mb-4 transition-all duration-500 ring-4 ring-white/20"
                        src="{{ $tableImageUrl }}"
                        alt="table image"
                    >
                    <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-coral text-white text-xs font-iransans-thin px-4 py-1 rounded-full shadow-soft">
                        {{ $tableName }}
                    </div>
                </div>

                <span class="font-dastnevis text-2xl mt-6 text-white text-shadow-lg text-center">
                    {{ $settings['title'] }}
                </span>
            </div>

            @guest
                <div class="w-full max-w-sm mx-auto mt-8">
                    <div class="card-glass p-6 rounded-3xl">
                        <livewire:login-form/>
                    </div>
                </div>
            @endguest

            @auth
                <a wire:navigate href="/?page=menu"
                    class="btn-secondary px-8 py-3.5 rounded-2xl text-sm shadow-glow-lg mt-8 inline-block animate-float">
                    جهت مشاهده منو کلیک کنید
                </a>
            @endauth

            <div class="flex items-center gap-6 mt-auto mb-8">
                <a href="https://instagram.com/{{ $settings['instagram'] }}" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 backdrop-blur-sm hover:bg-coral hover:scale-110 transition-all duration-300">
                    <svg class="w-5 h-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                        <path d="M 16 3 C 8.8324839 3 3 8.8324839 3 16 L 3 34 C 3 41.167516 8.8324839 47 16 47 L 34 47 C 41.167516 47 47 41.167516 47 34 L 47 16 C 47 8.8324839 41.167516 3 34 3 L 16 3 z M 16 5 L 34 5 C 40.086484 5 45 9.9135161 45 16 L 45 34 C 45 40.086484 40.086484 45 34 45 L 16 45 C 9.9135161 45 5 40.086484 5 34 L 5 16 C 5 9.9135161 9.9135161 5 16 5 z M 37 11 A 2 2 0 0 0 35 13 A 2 2 0 0 0 37 15 A 2 2 0 0 0 39 13 A 2 2 0 0 0 37 11 z M 25 14 C 18.936712 14 14 18.936712 14 25 C 14 31.063288 18.936712 36 25 36 C 31.063288 36 36 31.063288 36 25 C 36 18.936712 31.063288 14 25 14 z M 25 16 C 29.982407 16 34 20.017593 34 25 C 34 29.982407 29.982407 34 25 34 C 20.017593 34 16 29.982407 16 25 C 16 20.017593 20.017593 16 25 16 z"></path>
                    </svg>
                </a>

                <a href="tel:{{ $settings['mobile'] }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 backdrop-blur-sm hover:bg-coral hover:scale-110 transition-all duration-300">
                    <svg class="w-5 h-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                        <path d="M 14 3.9902344 C 8.4886661 3.9902344 4 8.4789008 4 13.990234 L 4 35.990234 C 4 41.501568 8.4886661 45.990234 14 45.990234 L 36 45.990234 C 41.511334 45.990234 46 41.501568 46 35.990234 L 46 13.990234 C 46 8.4789008 41.511334 3.9902344 36 3.9902344 L 14 3.9902344 z M 14 5.9902344 L 36 5.9902344 C 40.430666 5.9902344 44 9.5595687 44 13.990234 L 44 35.990234 C 44 40.4209 40.430666 43.990234 36 43.990234 L 14 43.990234 C 9.5693339 43.990234 6 40.4209 6 35.990234 L 6 13.990234 C 6 9.5595687 9.5693339 5.9902344 14 5.9902344 z M 18.048828 11.035156 C 16.003504 10.946776 14.45113 11.723922 13.474609 12.658203 C 12.986349 13.125343 12.633832 13.625179 12.392578 14.091797 C 12.151324 14.558415 11.998047 14.943108 11.998047 15.443359 C 11.998047 15.398799 11.987059 15.632684 11.980469 15.904297 C 11.973869 16.17591 11.97507 16.542045 12 16.984375 C 12.04996 17.869036 12.199897 19.065677 12.597656 20.484375 C 13.393174 23.321771 15.184446 27.043821 19.070312 30.929688 C 22.95618 34.815554 26.678014 36.606575 29.515625 37.402344 C 30.93443 37.800228 32.130881 37.949937 33.015625 38 C 33.457997 38.02503 33.822105 38.026091 34.09375 38.019531 C 34.365395 38.012931 34.601049 38.001953 34.556641 38.001953 C 35.056892 38.001953 35.441585 37.848676 35.908203 37.607422 C 36.374821 37.366168 36.874657 37.013651 37.341797 36.525391 C 38.276078 35.54887 39.053222 33.996496 38.964844 31.951172 C 38.922907 30.975693 38.381316 30.111858 37.582031 29.599609 C 36.96435 29.203814 36.005458 28.589415 34.753906 27.789062 C 33.301811 26.861299 31.44451 26.795029 29.929688 27.625 L 30.015625 27.582031 L 28.837891 28.087891 L 28.751953 28.148438 C 28.465693 28.349428 28.111154 28.386664 27.789062 28.251953 C 26.886813 27.874649 25.480985 27.133329 24.173828 25.826172 C 22.866671 24.519015 22.125351 23.113186 21.748047 22.210938 C 21.613336 21.888845 21.650568 21.534307 21.851562 21.248047 L 21.912109 21.162109 L 22.417969 19.984375 L 22.375 20.070312 C 23.204764 18.5... (line truncated to 2000 chars)
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
