<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#f2e8cf">

    @vite('resources/css/app.css')
    @livewireStyles

    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <title>{{ $title ?? 'Coral Food کورال فود' }}</title>
</head>
<body class="min-h-screen overflow-x-hidden">

    <!-- پس‌زمینه -->
    <div class="fixed inset-0 bg-gradient-warm -z-10"></div>

    <!-- دایره‌های دکوراتیو گلس مورفیسم -->
    <div class="fixed top-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-coral-from/15 blur-[100px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-[-5%] left-[-15%] w-[400px] h-[400px] rounded-full bg-coral/15 blur-[100px] pointer-events-none -z-10"></div>
    <div class="fixed top-[40%] left-[30%] w-[250px] h-[250px] rounded-full bg-coral-to/20 blur-[100px] pointer-events-none -z-10"></div>

    <div class="relative z-0">
        <livewire:header>

        <main class="max-w-screen-sm mx-auto pb-24 animate-fade-in-up">
            {{ $slot }}
        </main>

        <livewire:footer>
        <livewire:footer-menu>
    </div>

    @vite('resources/js/app.js')
    @stack('scripts')
    @livewireScripts

</body>
</html>
